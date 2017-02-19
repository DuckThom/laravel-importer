<?php

namespace Tests\Runners;

use Tests\TestCase;
use Luna\Importer\Contracts\Runner;
use Luna\Importer\Runners\CsvRunner;
use Luna\Importer\Contracts\Importer;
use Tests\TestImporter;

/**
 * Importer test
 *
 * @package     Luna\Importer
 * @subpackage  Tests
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class CsvRunnerTest extends TestCase
{
    /**
     * @var Runner
     */
    protected $runner;

    /**
     * @var Importer
     */
    protected $importer;

    protected function setUp()
    {
        $this->runner = new CsvRunner;
        $this->runner->setDryRun(true);

        $this->importer = new TestImporter;
    }

    /**
     * @test
     */
    public function parses_csv_line_correctly()
    {
        $data = str_getcsv(file_get_contents(__DIR__.'/../test.csv'), ';');

        $this->assertEquals(
            ['test' => 'foo', 'column' => 'baz'],
            $this->importer->parseLine($data)
        );
    }
}