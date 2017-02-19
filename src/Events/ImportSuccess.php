<?php

namespace Luna\Importer\Events;

use Luna\Importer\Contracts\Runner;
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
     * @var Runner
     */
    public $runner;

    /**
     * @var Importer
     */
    public $importer;

    /**
     * ImportSuccess constructor.
     *
     * @param  Runner  $runner
     * @param  Importer  $importer
     */
    function __construct(Runner $runner, Importer $importer)
    {
        $this->runner = $runner;
        $this->importer = $importer;
    }
}