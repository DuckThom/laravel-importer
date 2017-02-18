<?php

namespace Luna\Importer\Exceptions;

/**
 * Invalid column count exception
 *
 * @package     Luna\Importer
 * @subpackage  Exceptions
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class InvalidColumnCountException extends \Exception
{
    /**
     * InvalidColumnCountException constructor.
     *
     * @param  int  $line
     * @param  int  $got
     * @param  int  $expected
     * @param  int  $code
     * @param  \Exception|null  $previous
     */
    public function __construct($line, $got, $expected, $code = 0, \Exception $previous = null)
    {
        $message = "Invalid column count at line: {$line}. Got {$got}, expected {$expected}";

        parent::__construct($message, $code, $previous);
    }
}
