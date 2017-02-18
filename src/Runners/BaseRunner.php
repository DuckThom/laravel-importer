<?php

namespace Luna\Importer\Runners;

use Carbon\Carbon;
use Luna\Importer\Contracts\Runner;
use Illuminate\Support\Facades\File;
use Luna\Importer\Contracts\Importer;
use Luna\Importer\Exceptions\InvalidFileException;
use Luna\Importer\Exceptions\FileNotFoundException;

/**
 * Base runner
 *
 * @package     Luna\Importer
 * @subpackage  Runners
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
abstract class BaseRunner implements Runner
{
    /**
     * The time the import started
     *
     * @var Carbon
     */
    protected $now;

    /**
     * File handle of the file to be parsed
     *
     * @var resource
     */
    protected $file;

    /**
     * The amount of imported rows
     *
     * @var int
     */
    protected $lines = 0;

    /**
     * The amount of items that were added
     *
     * @var int
     */
    protected $added = 0;

    /**
     * The amount of items that were deleted
     *
     * @var int
     */
    protected $deleted = 0;

    /**
     * The amount of items that were updated
     *
     * @var int
     */
    protected $updated = 0;

    /**
     * The amount of unchanged items
     *
     * @var int
     */
    protected $unchanged = 0;

    /**
     * The importer instance
     *
     * @var Importer
     */
    protected $importer;

    /**
     * @inheritdoc
     */
    public function handle(Importer $importer): void
    {
        $this->now = Carbon::now();
        $this->importer = $importer;

        try {
            // Load the file
            $this->beforeImport();

            // Run the import
            $this->import();

            // Cleanup
            $this->afterImport();
        } finally {
            if ($this->importer->shouldCleanup()) {
                $this->removeFile();
            }
        }
    }

    /**
     * Remove the items that were not imported
     */
    public function removeStale()
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $query = $this->importer->getModelInstance()
            ->where('updated_at', '<', $this->now)
            ->orWhereNull('updated_at');

        $this->deleted = $query->count();

        return $query->delete();
    }

        /**
     * Check if the file is valid
     *
     * @return bool
     */
    public function validateFile(): bool
    {
        return true;
    }

    /**
     * Things to run before the import
     *
     * @return void
     * @throws InvalidFileException
     * @throws FileNotFoundException
     */
    public function beforeImport(): void
    {
        if (!File::exists($this->importer->getFilePath())) {
            throw new FileNotFoundException($this->importer->getFilePath());
        }

        $this->file = fopen($this->importer->getFilePath(), 'r');

        if (!$this->validateFile()) {
            throw new InvalidFileException;
        }
    }

    /**
     * The import handler
     *
     * @return void
     */
    abstract public function import(): void;

    /**
     * After import handler
     *
     * @return void
     */
    public function afterImport(): void
    {
        fclose($this->file);
    }

    /**
     * Remove the uploaded file
     *
     * @return void
     */
    public function removeFile(): void
    {
        File::delete($this->importer->getFilePath());
    }
}