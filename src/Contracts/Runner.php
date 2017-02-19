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
    public function beforeImport();

    /**
     * The import runner
     *
     * @return void
     */
    public function import();

    /**
     * Things to do after the import
     *
     * @return void
     */
    public function afterImport();

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

    /**
     * What to do when removing the file
     *
     * @return void
     */
    public function removeFile();

    /**
     * Determine which lines need to be removed by the importer.
     *
     * By default, the lines that were not present in the import file are
     * removed after the other lines are updated, added or remained unchanged
     *
     * @return void
     */
    public function removeStale();
}
