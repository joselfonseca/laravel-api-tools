<?php

namespace Joselfonseca\LaravelApiTools\Exceptions;

/**
 * Description of ValidationExceptionUseSimpleResponder
 *
 * @author desarrollo
 */
class ValidationExceptionUseSimpleResponder extends \Exception{
    
    public $validator;
    
    public function __construct($validator) {
        $this->validator = $validator;
    }
    
}
