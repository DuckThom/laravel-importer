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
}
