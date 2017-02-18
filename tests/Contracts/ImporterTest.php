<?php

namespace Tests;

use Luna\Importer\Contracts\Importer;

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
     * @expectedException \Exception
     * @expectedExceptionMessage Nothing to remove
     */
    public function it_should_remove_stale_items()
    {
        $this->importer->removeStale();
    }

    /**
     * @test
     */
    public function it_should_have_file_path()
    {
        $this->assertEquals(
            '/test.csv',
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

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Failed
     */
    public function it_should_do_something_on_failure()
    {
        $this->importer->importFailed([
            'exception' => new \Exception("Failed")
        ]);
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Success
     */
    public function it_should_do_something_on_success()
    {
        $this->importer->importSuccess();
    }
}