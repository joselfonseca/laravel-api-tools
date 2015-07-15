<?php

namespace Joselfonseca\LaravelApiTools\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ApiModelNotFoundException extends NotFoundHttpException{

    public function __construct($message = "We could not found what you were looking for", \Exception $previous = null, $code = 0)
    {
        parent::__construct($message, $previous, $code);
    }

}