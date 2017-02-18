<?php

namespace Luna\Importer;

use Illuminate\Support\Facades\Facade;

/**
 * Importer facade
 *
 * @package     Luna\Importer
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class ImporterFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'importer';
    }
}