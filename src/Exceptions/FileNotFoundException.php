<?php

namespace Luna\Importer\Exceptions;

use Exception;

/**
 * Class FileNotFoundException
 *
 * @package     Luna\Importer
 * @subpackage  Exceptions
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class FileNotFoundException extends \Exception
{
    /**
     * FileNotFoundException constructor.
     *
     * @param  string  $path
     * @param  int  $code
     * @param  Exception|null  $previous
     */
    public function __construct($path, $code = 0, Exception $previous = null)
    {
        $message = "CSV file not found: {$path}";

        parent::__construct($message, $code, $previous);
    }
}