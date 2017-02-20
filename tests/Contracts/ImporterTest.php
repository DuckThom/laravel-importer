<?php

namespace Tests\Contracts;

use Tests\TestCase;
use Tests\TestModel;
use Tests\TestImporter;
use Luna\Importer\Contracts\Importer;

/**
 * Importer contract test
 *
 * @package     Luna\Importer
 * @subpackage  Tests\Contracts
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class ImporterTest extends TestCase
{
    /**
     * @var Importer
     */
    protected $importer;

    public function setUp()
    {
        $this->importer = new TestImporter;
    }

    /**
     * @test
     */
    public function it_implements_importer()
    {
        $this->assertInstanceOf(Importer::class, $this->importer);
    }

    /**
     * @test
     */
    public function it_should_determine_cleanup()
    {
        $this->assertEquals(false, $this->importer->shouldCleanup());
    }

    /**
     * @test
     */
    public function it_should_have_file_path()
    {
        $this->assertEquals(
            realpath(__DIR__.'/../test.csv'),
            $this->importer->getFilePath()
        );
    }

    /**
     * @test
     */
    public function it_should_have_model_class()
    {
        $this->assertEquals(
            TestModel::class,
            $this->importer->getModel()
        );
    }

    /**
     * @test
     */
    public function it_should_have_model_instance()
    {
        $this->assertInstanceOf(TestModel::class, $this->importer->getModelInstance());
    }

    /**
     * @test
     */
    public function it_should_have_unique_key()
    {
        $this->assertEquals(
            'test',
            $this->importer->getUniqueKey()
        );
    }
}
