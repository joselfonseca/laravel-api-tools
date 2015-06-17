<?php

namespace Joselfonseca\LaravelApiTools\Exceptions;

use Exception;

/**
 * Description of StoreResourceFailedException
 *
 * @author josefonseca
 */
class StoreResourceFailedException extends Exception
{

    public function __construct($message, $errors)
    {
        $this->message = $message;
        $this->errors  = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}