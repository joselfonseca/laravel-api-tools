<?php

namespace Joselfonseca\LaravelApiTools\Exceptions;

use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

/**
 * Description of InvalidArgumentException
 *
 * @author desarrollo
 */
class InvalidArgumentException extends ServiceUnavailableHttpException
{

    public function __construct($retryAfter = null, $message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct($retryAfter, $message, $previous, $code);
    }
    
}
