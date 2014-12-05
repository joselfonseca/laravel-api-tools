<?php

namespace Joselfonseca\LaravelApiTools\Traits;

use Joselfonseca\LaravelApiTools\Exceptions\ValidationException;
use Joselfonseca\LaravelApiTools\Exceptions\ValidationExceptionUseSimpleResponder;
use Joselfonseca\LaravelApiTools\Exceptions\ModelNotFoundExceptionUseSimpleResponder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Simple Crud Functions for Eloquent Models
 * @author Jose Fonseca <jose@ditecnologia.com>
 * @package Joselfonseca\LaravelApiTools
 */
trait ModelSimpleCrudTrait {

    /**
     * Create a resource
     * @param type $input
     * @return type
     */
    public function CreateResource($input) {
        try {
            $this->validate($input);
            $model = $this->create($input);
        } catch (ValidationException $e) {
            if (\Config::get('laravel-api-tools::responder::responder') === "dingo") {
                throw new \Dingo\Api\Exception\StoreResourceFailedException(\Config::get('laravel-api-tools::ValidationCreationErrorMessage'), $e->validator->errors());
            }
            throw new ValidationExceptionUseSimpleResponder($e->validator);
        }
        return $model;
    }

    /**
     * Validate input
     * @param type $input
     * @throws ValidationException
     */
    public function validate($input) {
        if (!isset($this->validationRules)) {
            $this->validationRules = [];
        }
        $validation = \Validator::make($input, $this->validationRules);
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }
    }
    /**
     * Update a resource
     * @param type $id
     * @param type $input
     * @return type
     * @throws \Dingo\Api\Exception\StoreResourceFailedException
     */
    public function updateResource($id, $input) {
        try {
            $this->validate($input);
            $model = $this->findOrFail($id);
            foreach ($input as $key => $value){
                $model->{$key} = $value;
            }
            $model->save();
        } catch (ValidationException $e) {
            if (\Config::get('laravel-api-tools::responder::responder') === "dingo") {
                throw new \Dingo\Api\Exception\StoreResourceFailedException(\Config::get('laravel-api-tools::ValidationCreationErrorMessage'), $e->validator->errors());
            }
            throw new ValidationExceptionUseSimpleResponder($e->validator);
        } catch(ModelNotFoundException $e){
            if (\Config::get('laravel-api-tools::responder::responder') === "dingo") {
                throw new \Dingo\Api\Exception\ResourceException(\Config::get('laravel-api-tools::ResourceNotFound'));
            }
            throw new ModelNotFoundExceptionUseSimpleResponder($e->validator);
        }
        return $model;
    }
    /**
     * Delete a resource
     * @param type $id
     * @return type
     */
    public function deleteResource($id){
        try {
            $model = $this->findOrFail($id);
            $model->delete();
        } catch(ModelNotFoundException $e){
            if (\Config::get('laravel-api-tools::responder::responder') === "dingo") {
                throw new \Dingo\Api\Exception\ResourceException(\Config::get('laravel-api-tools::ResourceNotFound'));
            }
            throw new ModelNotFoundExceptionUseSimpleResponder();
        }
        return true;
    }

}
