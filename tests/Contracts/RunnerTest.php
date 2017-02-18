<?php

namespace Tests;

use Luna\Importer\Contracts\Runner;

class RunnerTest extends TestCase
{
    /**
     * @var Runner
     */
    protected $runner;

    public function setUp()
    {
        $this->runner = new TestRunner;
    }

    /**
     * @test
     */
    public function is_instance_of_runner()
    {
        $this->assertInstanceOf(Runner::class, $this->runner);
    }
}