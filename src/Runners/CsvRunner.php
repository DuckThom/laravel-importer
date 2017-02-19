<?php

namespace Luna\Importer\Runners;

use Illuminate\Support\Facades\DB;
use Luna\Importer\Contracts\Runner;
use Illuminate\Support\Facades\Validator;
use Luna\Importer\Events\ImportFailed;
use Luna\Importer\Events\ImportSuccess;
use Luna\Importer\Exceptions\InvalidCsvLineException;

/**
 * CSV runner
 *
 * @package     Luna\Importer
 * @subpackage  Runners
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class CsvRunner extends BaseRunner implements Runner
{
    /**
     * Run the import
     *
     * @return void
     * @throws \Luna\Importer\Exceptions\InvalidCsvLineException
     * @throws \Exception
     */
    public function import()
    {
        DB::beginTransaction();

        try {
            $iteration = 0;

            while (! feof($this->file)) {
                $iteration++;

                $csvLine = str_getcsv(fgets($this->file), ';');
                $columnCount = count($csvLine);

                if ($columnCount === 1 && !$this->importer->validateLine($csvLine)) {
                    continue;
                } elseif ($this->importer->validateLine($csvLine)) {
                    $this->handleLine($csvLine);
                } else {
                    throw new InvalidCsvLineException($iteration);
                }
            }

            $this->lines = $this->importer->getModelInstance()->count();

            $this->removeStale();

            if (!$this->dryRun) {
                DB::commit();
            }

            event(new ImportSuccess($this->importer));
        } catch (\Exception $e) {
            DB::rollBack();

            event(new ImportFailed($this->importer, $e));

            // Re-throw the exception to catch it from outside
            throw $e;
        }
    }

    /**
     * Handle a csv line
     *
     * @param  array  $csvLine
     * @return void
     * @throws InvalidCsvLineException
     */
    public function handleLine(array $csvLine)
    {
        $fields = $this->importer->parseLine($csvLine);
        $hash = $this->makeHash($fields);
        $item = $this->importer->getModelInstance()
            ->where($this->importer->getUniqueKey(), $fields[$this->importer->getUniqueKey()])
            ->lockForUpdate()
            ->first();

        if ($item === null) {
            // Create a new item and fill it with the fields
            $item = $this->importer->getModelInstance();
            $item->fill($fields);

            $this->added++;
        } elseif ($hash !== $item->hash) {
            // Update the fields if there is a hash mismatch
            $item->fill($fields);

            $this->updated++;
        } elseif ($hash === $item->hash) {
            $this->unchanged++;
        }

        $item->hash = $hash;

        if (!$this->dryRun) {
            $item->save();
        }
    }

    /**
     * Check if the csv file is valid
     *
     * @return bool
     */
    public function validateFile(): bool
    {
        return Validator::make(
            ['fileType' => finfo_file(finfo_open(FILEINFO_MIME_TYPE), $this->importer->getFilePath())],
            ['fileType' => 'required|string:text/plain|string:text/csv']
        )->passes();
    }
}
