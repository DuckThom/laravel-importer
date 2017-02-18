<?php

namespace Luna\Importer\Contracts;

/**
 * Importer contract
 *
 * @package     Luna\Importer
 * @subpackage  Contracts
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
interface Importer
{
    /**
     * Parse a csv line to an importable array for the model
     *
     * @param  array  $data
     * @return array
     */
    public function parseLine(array $data): array;

    /**
     * Validate the raw line data
     *
     * @param  array  $data
     * @return bool
     */
    public function validateLine(array $data): bool;

    /**
     * Get the model class path for the import
     *
     * @return string
     */
    public function getModel(): string;

    /**
     * Get the file to import
     *
     * @return string
     */
    public function getFilePath(): string;

    /**
     * Get the unique column key
     *
     * This should match a unique column in the table as
     * this is used to determine if a row needs to be updated
     * or inserted
     *
     * @return string
     */
    public function getUniqueKey(): string;

    /**
     * Determine if the source file should be removed
     *
     * @return bool
     */
    public function shouldCleanup(): bool;

    /**
     * Things to do when the import succeeded
     *
     * @return void
     */
    public function importSuccess(): void;

    /**
     * Things to do when the import failed
     *
     * @param  array  $data
     * @return void
     */
    public function importFailed(array $data): void;

    /**
     * Determine which lines need to be removed by the importer.
     *
     * By default, the lines that were not present in the import file are
     * removed after the other lines are updated, added or remained unchanged
     */
    public function removeStale(): void;
}