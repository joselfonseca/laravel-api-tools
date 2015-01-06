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
     * @param array $input
     * @return type
     */
    public function createResource($input) {
        return $this->create($input);;
    }

    /**
     * Validate input
     * @param array $input
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
     * @param int $id
     * @param array $input
     * @return type
     * @throws \Dingo\Api\Exception\StoreResourceFailedException
     */
    public function updateResource($id, $input) {
        $model = $this->findOrFail($id);
        foreach ($input as $key => $value){
            $model->{$key} = $value;
        }
        $model->save();
        return $model;
    }
    /**
     * Delete a resource
     * @param int $id
     * @return type
     */
    public function deleteResource($id){
        try {
            $model = $this->findOrFail($id);
            $model->delete();
        } catch(ModelNotFoundException $e){
            if (\Config::get('laravel-api-tools::responder') === "dingo") {
                throw new \Dingo\Api\Exception\ResourceException(\Config::get('laravel-api-tools::ResourceNotFound'));
            }
            throw new ModelNotFoundExceptionUseSimpleResponder();
        }
        return true;
    }


    /**
     * Register some events
     */
    public static function boot(){
        parent::boot();
        static::creating(function ($model) {
            $model->validateCreateFromEvent($model);
        });
        static::updating(function ($model) {
            $model->validateUpdateFromEvent($model);
        });
    }

    /**
     * @param $model
     * @throws ModelNotFoundExceptionUseSimpleResponder
     * @throws ValidationExceptionUseSimpleResponder
     */
    private function validateUpdateFromEvent($model){
        try {
            $model->validate($model->toArray());
        } catch (ValidationException $e) {
            if (\Config::get('laravel-api-tools::responder') === "dingo") {
                throw new \Dingo\Api\Exception\StoreResourceFailedException(\Config::get('laravel-api-tools::ValidationCreationErrorMessage'), $e->validator->errors());
            }
            throw new ValidationExceptionUseSimpleResponder($e->validator);
        } catch(ModelNotFoundException $e){
            if (\Config::get('laravel-api-tools::responder') === "dingo") {
                throw new \Dingo\Api\Exception\ResourceException(\Config::get('laravel-api-tools::ResourceNotFound'));
            }
            throw new ModelNotFoundExceptionUseSimpleResponder($e->validator);
        }
    }

    /**
     * @param $model
     * @throws ValidationExceptionUseSimpleResponder
     */
    private function validateCreateFromEvent($model){
        try {
            $model->validate($model->toArray());
        } catch (ValidationException $e) {
            if (\Config::get('laravel-api-tools::responder') === "dingo") {
                throw new \Dingo\Api\Exception\StoreResourceFailedException(\Config::get('laravel-api-tools::ValidationCreationErrorMessage'), $e->validator->errors());
            }
            throw new ValidationExceptionUseSimpleResponder($e->validator);
        }
    }

}
