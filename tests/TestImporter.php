<?php

namespace Tests;

use Luna\Importer\Contracts\Importer;
use Luna\Importer\Importers\BaseImporter;

/**
 * Test runner
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

    public function removeStale(): void
    {
        throw new \Exception("Nothing to remove");
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
        return '/test.csv';
    }

    public function getModel(): string
    {
        return TestModel::class;
    }

    public function getUniqueKey(): string
    {
        return 'test';
    }

    public function importSuccess(): void
    {
        throw new \Exception("Success");
    }

    public function importFailed(array $data): void
    {
        throw $data['exception'];
    }

    public function validateLine(array $data): bool
    {
        return count($data) === 3;
    }
}