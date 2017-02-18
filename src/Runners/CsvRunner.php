<?php

namespace Luna\Importer\Runners;

use Illuminate\Support\Facades\DB;
use Luna\Importer\Contracts\Runner;

/**
 * CSV runner
 *
 * @package     Luna\Importer
 * @subpackage  Runners
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
abstract class CsvRunner extends BaseRunner implements Runner
{
    /**
     * Run the import
     *
     * @return void
     * @throws \Luna\Importer\Exceptions\InvalidColumnCountException
     * @throws \Exception
     */
    public function import(): void
    {
        DB::beginTransaction();

        try {
            $iteration = 0;

            while (! feof($this->file)) {
                $iteration++;
                $csvLine = str_getcsv(fgets($this->file), ';');
                $columnCount = count($csvLine);

                if ($columnCount === 1 && $this->columnCount !== 1) {
                    continue;
                } elseif ($columnCount === $this->columnCount) {
                    $fields = $this->parseLine($csvLine);
                    $item = $this->getModelInstance()
                        ->where($this->getUniqueKey(), $fields[$this->getUniqueKey()])
                        ->lockForUpdate()
                        ->first();
                    $hash = $this->makeHash($fields);

                    if ($item === null) {
                        // Create a new item and fill it with the fields
                        $item = $this->getModelInstance();
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
                    $item->imported_at = $this->now;
                    $item->save();
                } else {
                    throw new InvalidColumnCountException($iteration, $columnCount, $this->columnCount);
                }
            }

            $this->lines = $this->getModelInstance()->count();

            $this->removeStale();

            DB::commit();

            $this->importSuccess();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->importFailed([
                'line' => $iteration ?? false,
                'exception' => $e,
                'csv' => $csvLine ?? false
            ]);

            // Re-throw the exception to catch it from outside
            throw $e;
        }
    }

    /**
     * Check if the csv file is valid
     *
     * @return bool
     */
    protected function isValid(): bool
    {
        return \Validator::make(
            ['fileType' => finfo_file(finfo_open(FILEINFO_MIME_TYPE), $this->getFilePath())],
            ['fileType' => 'required|string:text/plain|string:text/csv']
        )->passes();
    }

    /**
     * Import success handler
     *
     * @deprecated
     * @return void
     */
    protected function importSuccess(): void
    {
        $message = __(':count :type zijn geimporteerd in :time seconden. <br />Geheugen gebruik: :memory<br />Nieuwe regels: :added<br />Aangepaste regels: :updated<br />Verwijderde regels: :deleted<br />Niet-aangepaste regels: :unchanged', [
            'count' => app('format')->number($this->lines),
            'type' => __(str_plural($this->getType(), $this->lines)),
            'time' => Carbon::now()->diffInSeconds($this->now),
            'memory' => app('format')->bytes(memory_get_peak_usage()),
            'added' => $this->added,
            'updated' => $this->updated,
            'deleted' => $this->deleted,
            'unchanged' => $this->unchanged
        ]);

        $this->updateImportStatus($message, false);
    }

    /**
     * Import error handler
     *
     * @deprecated
     * @param  array  $results
     * @return void
     */
    protected function importFailed(array $results)
    {
        $message = __('An error has occurred during the :type import on line :line, the database has not been altered. The error message is: :error. The csv data: :csv', [
            'line' => ($results['line'] ?: 0),
            'type' => $this->getType(),
            'error' => $results['exception']->getMessage(),
            'csv' => ($results['csv'] ? implode(',', $results['csv']) : '(Not set)')
        ]);

        $this->updateImportStatus($message, true);

        $this->sendErrorMail($message);
    }

    /**
     * Update the import status message
     *
     * @deprecated
     * @param  string  $message
     * @param  bool  $isError
     */
    protected function updateImportStatus(string $message, bool $isError)
    {
        Content::where('name', 'admin.' . $this->getType() . '_import')->update([
            'content'    => $message,
            'updated_at' => Carbon::now('Europe/Amsterdam'),
            'error'      => (int) $isError,
        ]);
    }

    /**
     * Send an error message
     *
     * @deprecated
     * @param  string  $errorMessage
     * @return void
     */
    protected function sendErrorMail($errorMessage)
    {
        \Mail::send('email.import_error_notice', [
            'error' => $errorMessage,
            'type' => $this->getType()
        ], function ($message) {
            $message->subject('[' . config('app.name') . '] ' . ucfirst($this->getType()) . ' import error');
        });
    }
}