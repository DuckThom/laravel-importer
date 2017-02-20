<?php

namespace Tests;

use Luna\Importer\Contracts\Importer;
use Luna\Importer\Importers\BaseImporter;

/**
 * Test importer
 *
 * @package     Luna\Importer
 * @subpackage  Tests
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class TestImporter extends BaseImporter implements Importer
{
    public function shouldCleanup(): bool
    {
        return false;
    }

    public function parseLine(array $data): array
    {
        return [
            'test' => $data[0],
            'column' => $data[2]
        ];
    }

    public function getFilePath(): string
    {
        return __DIR__.'/test.csv';
    }

    public function getModel(): string
    {
        return TestModel::class;
    }

    public function getUniqueKey(): string
    {
        return 'test';
    }

    public function validateLine(array $data): bool
    {
        return count($data) === 3;
    }
}
