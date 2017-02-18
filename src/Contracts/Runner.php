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
     * The import runner
     *
     * @return void
     */
    public function import(): void;

    /**
     * Start the import
     *
     * @return void
     */
    public function handle();

    /**
     * Check if the file is valid for importing
     *
     * @return bool
     */
    public function isValid(): bool;
}