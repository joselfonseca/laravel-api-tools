<?php

namespace Joselfonseca\LaravelApiTools\Exceptions;

/**
 * When validation fails.
 *
 * @author Jose Luis Fonseca
 */
class ValidationException extends \Exception{
    
    public $validator;
    
    public function __construct($validator) {
        $this->validator = $validator;
    }
    
    
}
