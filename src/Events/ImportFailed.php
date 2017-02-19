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
class ImportFailed
{
    /**
     * @var Importer
     */
    public $importer;

    /**
     * @var \Exception
     */
    public $exception;

    /**
     * ImportSuccess constructor.
     *
     * @param  Importer  $importer
     * @param  \Exception  $exception
     */
    function __construct(Importer $importer, \Exception $exception)
    {
        $this->importer = $importer;
        $this->exception = $exception;
    }
}