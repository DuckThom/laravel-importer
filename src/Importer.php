<?php

namespace Luna\Importer;

use Luna\Importer\Contracts\Runner;
use Luna\Importer\Contracts\Importer as ImporterContract;

/**
 * Importer contract
 *
 * @package     Luna\Importer
 * @subpackage  Importers
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
abstract class Importer implements ImporterContract
{
    /**
     * This contains all the registered runners
     *
     * @var Runner
     */
    protected $runner;

    /**
     * Importer constructor.
     *
     * @param  Runner  $runner
     */
    public function __construct(Runner $runner)
    {
        $this->runner = $runner;
    }

    /**
     * Set a new runner
     *
     * @param  Runner  $runner
     * @return $this
     */
    public function setRunner(Runner $runner)
    {
        $this->runner = new $runner;

        return $this;
    }

    /**
     * Get the current runner instance
     *
     * @return Runner
     */
    public function getRunnerInstance(): Runner
    {
        return $this->runner;
    }

    /**
     * Run the import
     *
     * @return void
     */
    public function run(): void
    {
        $this->runner->import();
    }
}