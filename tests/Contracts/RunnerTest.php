<?php

namespace Tests\Contracts;

use Tests\TestCase;
use Tests\TestRunner;
use Luna\Importer\Contracts\Runner;

/**
 * Runner contract test
 *
 * @package     Luna\Importer
 * @subpackage  Tests\Contracts
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class RunnerTest extends TestCase
{
    /**
     * @var Runner
     */
    protected $runner;

    public function setUp()
    {
        $this->runner = new TestRunner();
    }

    /**
     * @test
     */
    public function is_instance_of_runner()
    {
        $this->assertInstanceOf(Runner::class, $this->runner);
    }
}