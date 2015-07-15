<?php

namespace Joselfonseca\LaravelApiTools\Exceptions;

use Dingo\Api\Exception\ResourceException;

/**
 * When validation fails.
 *
 * @author Jose Luis Fonseca
 */
class ValidationException extends ResourceException{
    
    public function __construct($validator) {
        parent::__construct('Validation Fail', $validator->errors(), null, [], 0);
    }

}
