<?php

namespace Luna\Importer\Exceptions;

use Exception;

/**
 * Runner not registered exception
 *
 * @package     Luna\Importer
 * @subpackage  Exceptions
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class RunnerNotRegisteredException extends \Exception
{
    /**
     * RunnerNotFoundException constructor.
     *
     * @param  string  $runner
     * @param  int  $code
     * @param  Exception|null  $previous
     */
    public function __construct($runner, $code = 0, Exception $previous = null)
    {
        $message = "Runner '{$runner}' has not been registered.\nVisit https://duckthom.github.io/laravel-importer/docs for more info.";

        parent::__construct($message, $code, $previous);
    }
}
