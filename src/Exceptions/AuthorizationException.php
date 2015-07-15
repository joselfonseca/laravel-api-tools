<?php

namespace Joselfonseca\LaravelApiTools\Exceptions;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Description of AuthorizationException
 *
 * @author josefonseca
 */
class AuthorizationException extends UnauthorizedHttpException
{
    public function __construct($challenge = "Token", $message = "Authorization Failed", \Exception $previous = null, $code = 0)
    {
        parent::__construct($challenge, $message, $previous, $code);
    }
}