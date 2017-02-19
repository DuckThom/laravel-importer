<?php

namespace Luna\Importer\Importers;

use Luna\Importer\Contracts\Importer;

/**
 * Base importer class
 *
 * @package     Luna\Importer
 * @subpackage  Importers
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
abstract class BaseImporter implements Importer
{
    /**
     * Get a new instance of the model class
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModelInstance()
    {
        $model = $this->getModel();

        return new $model;
    }

    /**
     * Successful import handler
     *
     * Default: Do nothing
     */
    public function importSuccess()
    {
        //
    }

    /**
     * Failed import handler
     *
     * Default: Do nothing
     *
     * @param  array  $data
     */
    public function importFailed(array $data)
    {
        //
    }
}
