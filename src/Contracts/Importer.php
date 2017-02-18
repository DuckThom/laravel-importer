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
     * Run the import
     *
     * @return void
     */
    public function run(): void;

    /**
     * Get the current runner instance
     *
     * @return Runner
     */
    public function getRunnerInstance(): Runner;

    /**
     * Set the runner instance
     *
     * @param  Runner  $runner
     * @return $this
     */
    public function setRunner(Runner $runner);

    /**
     * Parse a csv line to an importable array
     *
     * @param  array  $data
     * @return array
     */
    public function parseLine(array $data): array;

    /**
     * Get the expected column count
     *
     * @return int
     */
    public function getColumnCount(): int;

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
     * Get the import type
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Get the unique column key
     *
     * @return string
     */
    public function getUniqueKey(): string;
}