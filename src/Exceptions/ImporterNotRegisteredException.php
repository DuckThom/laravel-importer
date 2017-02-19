<?php

namespace Luna\Importer\Exceptions;

use Exception;

/**
 * Importer not registered exception
 *
 * @package     Luna\Importer
 * @subpackage  Exceptions
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class ImporterNotRegisteredException extends \Exception
{
    /**
     * ImporterNotRegisteredException constructor.
     *
     * @param  string  $importer
     * @param  int  $code
     * @param  Exception|null  $previous
     */
    public function __construct($importer, $code = 0, Exception $previous = null)
    {
        $message = "Importer '{$importer}' has not been registered.\nVisit https://duckthom.github.io/laravel-importer/docs for more info.";

        parent::__construct($message, $code, $previous);
    }
}
