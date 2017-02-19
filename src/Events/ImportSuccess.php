<?php

namespace Luna\Importer\Events;

use Luna\Importer\Contracts\Importer;

/**
 * ImportSuccess event
 *
 * @package     Luna\Importer
 * @subpackage  Events
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class ImportSuccess
{
    /**
     * @var Importer
     */
    public $importer;

    /**
     * ImportSuccess constructor.
     *
     * @param  Importer  $importer
     */
    function __construct(Importer $importer)
    {
        $this->importer = $importer;
    }
}