<?php

namespace Luna\Importer;

use Luna\Importer\Contracts\Runner;
use Luna\Importer\Contracts\Importer as ImporterContract;
use Luna\Importer\Exceptions\RunnerNotRegisteredException;
use Luna\Importer\Exceptions\ImporterNotRegisteredException;

/**
 * Importer
 *
 * @package     Luna\Importer
 * @subpackage  Importers
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class Importer
{
    /**
     * The registered runners
     *
     * @var array
     */
    protected $runners = [];

    /**
     * The registered importers
     *
     * @var array
     */
    protected $importers = [];

    /**
     * The active runner
     *
     * @var Runner
     */
    protected $runner;

    /**
     * The active importer
     *
     * @var ImporterContract
     */
    protected $importer;

    /**
     * Importer constructor.
     */
    public function __construct()
    {
        $this->runners = config('importer.runners');
        $this->importers = config('importer.importers');

        $this->runner = $this->runners['default'];
        $this->importers = $this->importers['default'];
    }

    /**
     * Set the runner
     *
     * @param  Runner|string  $runner
     * @return $this
     */
    public function runner($runner)
    {
        if ($runner instanceof Runner) {
            $this->runner = $runner;
        } else {
            $this->runner = $this->getRunner($runner);
        }

        return $this;
    }

    /**
     * Set the importer
     *
     * @param  ImporterContract  $importer
     * @return $this
     */
    public function importer(ImporterContract $importer)
    {
        if ($importer instanceof ImporterContract) {
            $this->importer = $importer;
        } else {
            $this->importer = $this->getImporter($importer);
        }

        return $this;
    }

    /**
     * Get a runner instance from the registered runners list
     *
     * @param  string  $runner
     * @return Runner
     * @throws RunnerNotRegisteredException
     */
    public function getRunner(string $runner): Runner
    {
        if (!isset($this->runners[$runner])) {
            throw new RunnerNotRegisteredException($runner);
        }

        return new $this->runners[$runner];
    }

    /**
     * Get a runner instance from the registered runners list
     *
     * @param  string  $importer
     * @return ImporterContract
     * @throws ImporterNotRegisteredException
     */
    public function getImporter(string $importer): ImporterContract
    {
        if (!isset($this->importers[$importer])) {
            throw new ImporterNotRegisteredException($importer);
        }

        return new $this->importers[$importer];
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
     * Get the current importer instance
     *
     * @return ImporterContract
     */
    public function getImporterInstance(): ImporterContract
    {
        return $this->importer;
    }

    /**
     * Run the import
     *
     * @return void
     */
    public function run(): void
    {
        $this->getRunnerInstance()->handle($this->getImporterInstance());
    }
}