<?php


namespace Joselfonseca\LaravelApiTools\Traits;

use Joselfonseca\LaravelApiTools\Exceptions\ValidationException;
use Joselfonseca\LaravelApiTools\ApiToolsResponder;
use Illuminate\Validation\Factory as LaravelValidator;

/**
 * Simple Crud Functions for Eloquent Models
 * @author Jose Fonseca <jose@ditecnologia.com>
 * @package Joselfonseca\LaravelApiTools
 */

trait ModelSimpleCrudTrait {
    
    public $validationRules = [];
    
    /**
     * Create a resource
     * @param type $input
     * @return type
     */
    public function CreateResource($input){
        try{
            $this->validate($input);
            $model = $this->create($input);
        }catch(ValidationException $e){
            return ApiToolsResponder::validationError($e->validator);
        }
        return $model;
    }
    /**
     * Validate input
     * @param type $input
     * @throws ValidationException
     */
    public function validate($input){
        $validator = new LaravelValidator;
        $validation = $validator->make($input, $this->rulvalidationRuleses);
        if($validation->fails()){
            throw new ValidationException($validation);
        }
    }
    
}
