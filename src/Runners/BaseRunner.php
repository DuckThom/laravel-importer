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
    public $now;

    /**
     * File handle of the file to be parsed
     *
     * @var resource
     */
    public $file;

    /**
     * The amount of imported rows
     *
     * @var int
     */
    public $lines = 0;

    /**
     * The amount of items that were added
     *
     * @var int
     */
    public $added = 0;

    /**
     * The amount of items that were deleted
     *
     * @var int
     */
    public $deleted = 0;

    /**
     * The amount of items that were updated
     *
     * @var int
     */
    public $updated = 0;

    /**
     * The amount of unchanged items
     *
     * @var int
     */
    public $unchanged = 0;

    /**
     * If true, don't make changes to the database
     *
     * @var bool
     */
    public $dryRun = false;

    /**
     * The importer instance
     *
     * @var Importer
     */
    public $importer;

    /**
     * @inheritdoc
     */
    public function handle(Importer $importer)
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
     * Determine which lines need to be removed by the importer.
     *
     * By default, the lines that were not present in the import file are
     * removed after the other lines are updated, added or remained unchanged
     *
     * @return void
     */
    public function removeStale()
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $query = $this->importer->getModelInstance()
            ->where('updated_at', '<', $this->now)
            ->orWhereNull('updated_at');

        $this->deleted = $query->count();

        $query->delete();
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
    public function beforeImport()
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
    abstract public function import();

    /**
     * After import handler
     *
     * @return void
     */
    public function afterImport()
    {
        fclose($this->file);
    }

    /**
     * Remove the uploaded file
     *
     * @return void
     */
    public function removeFile()
    {
        File::delete($this->importer->getFilePath());
    }

    /**
     * Set the dry run status
     *
     * @param  bool  $dryRun
     * @return $this
     */
    public function setDryRun(bool $dryRun)
    {
        $this->dryRun = $dryRun;

        return $this;
    }

    /**
     * Make a hash of the data to be imported
     *
     * The hash made from this method will determine if the row
     * needs to be updated or not.
     *
     * @param  array  $data
     * @return string
     */
    public function makeHash(array $data): string
    {
        return sha1(implode($data));
    }
}
