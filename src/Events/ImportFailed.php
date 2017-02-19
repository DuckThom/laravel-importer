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
class ImportFailed
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
     * @var \Exception
     */
    public $exception;

    /**
     * ImportSuccess constructor.
     *
     * @param  Runner  $runner
     * @param  Importer  $importer
     * @param  \Exception  $exception
     */
    public function __construct(Runner $runner, Importer $importer, \Exception $exception)
    {
        $this->runner = $runner;
        $this->importer = $importer;
        $this->exception = $exception;
    }
}
