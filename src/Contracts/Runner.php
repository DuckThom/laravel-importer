<?php

namespace Luna\Importer\Contracts;

/**
 * Runner contract
 *
 * @package     Luna\Importer
 * @subpackage  Contracts
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
interface Runner
{
    /**
     * Things to do before the import
     *
     * @return void
     */
    public function beforeImport(): void;

    /**
     * The import runner
     *
     * @return void
     */
    public function import(): void;

    /**
     * Things to do after the import
     *
     * @return void
     */
    public function afterImport(): void;

    /**
     * Start the import
     *
     * @param  Importer  $importer
     * @return void
     */
    public function handle(Importer $importer);

    /**
     * Check if the file is valid for importing
     *
     * @return bool
     */
    public function validateFile(): bool;
}