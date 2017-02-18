<?php

namespace Tests;

use Luna\Importer\Runners\BaseRunner;

class TestRunner extends BaseRunner
{
    public function import(): void
    {
        //
    }

    public function isValid(): bool
    {
        return true;
    }
}