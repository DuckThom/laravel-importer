<?php

namespace Luna\Importer\Exceptions;

/**
 * Invalid csv line exception
 *
 * @package     Luna\Importer
 * @subpackage  Exceptions
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class InvalidCsvLineException extends \Exception
{
    /**
     * InvalidColumnCountException constructor.
     *
     * @param  int  $line
     * @param  int  $code
     * @param  \Exception|null  $previous
     */
    public function __construct(int $line, int $code = 0, \Exception $previous = null)
    {
        $message = "Line {$line} in the CSV file failed it's validation checks.";

        parent::__construct($message, $code, $previous);
    }
}
