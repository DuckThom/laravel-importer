<?php

namespace Luna\Importer\Runners;

use Carbon\Carbon;
use Luna\Importer\Contracts\Importer;
use Luna\Importer\Contracts\Runner;
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
     * The fully qualified class name for the model
     *
     * @var string
     */
    protected $model;

    /**
     * The amount of imported rows
     *
     * @var int
     */
    protected $lines = 0;

    /**
     * The amount of expected columns
     *
     * @var int
     */
    protected $columnCount = 0;

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
     * Remove the file after the import is done
     *
     * @var bool
     */
    protected $cleanUp = true;

    /**
     * @inheritdoc
     */
    abstract public function isValid(): bool;

    /**
     * @inheritdoc
     */
    abstract public function import(): void;

    /**
     * BaseImporter constructor.
     */
    public function __construct(Importer $importer)
    {
        $this->now = Carbon::now();
        $this->model = $this->getModel();
        $this->columnCount = $this->getColumnCount();
    }

    /**
     * @inheritdoc
     */
    public function handle(): void
    {
        try {
            $this->beforeImport();

            $this->import();

            $this->afterImport();
        } finally {
            if ($this->cleanUp) {
                $this->removeFile();
            }
        }
    }

    /**
     * Get a new instance of the stored model class
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getModelInstance(): \Illuminate\Database\Eloquent\Model
    {
        return new $this->model;
    }

    /**
     * Remove the items that were not imported
     *
     * @return int
     */
    protected function removeStale(): int
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $query = $this->getModelInstance()
            ->where('imported_at', '<', $this->now)
            ->orWhereNull('imported_at')
            ->orWhereNull('hash');

        $this->deleted = $query->count();

        return $query->delete();
    }

    /**
     * Create a hash from the fields to be imported
     * sha1 is good enough for this hash
     *
     * @param  array  $data
     * @return string
     */
    protected function makeHash(array $data): string
    {
        return sha1(implode($data));
    }

    /**
     * Things to run before the import
     *
     * @return bool
     * @throws InvalidFileException
     * @throws FileNotFoundException
     */
    protected function beforeImport(): bool
    {
        if (!\File::exists($this->getFilePath())) {
            throw new FileNotFoundException($this->getFilePath());
        }

        $this->file = fopen($this->getFilePath(), 'r');

        if (!$this->isValid()) {
            throw new InvalidFileException;
        }

        return true;
    }

    /**
     * After import handler
     *
     * @return void
     */
    protected function afterImport(): void
    {
        fclose($this->file);
    }

    /**
     * Remove the uploaded file
     *
     * @return void
     */
    protected function removeFile(): void
    {
        \File::delete($this->getFilePath());
    }
}