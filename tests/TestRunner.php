<?php

namespace Tests;

use Luna\Importer\Contracts\Runner;
use Luna\Importer\Runners\BaseRunner;

class TestRunner extends BaseRunner implements Runner
{
    public function import()
    {
        //
    }

    public function validateFile(): bool
    {
        return false;
    }
}