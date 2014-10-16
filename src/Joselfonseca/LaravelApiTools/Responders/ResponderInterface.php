<?php

namespace Joselfonseca\LaravelApiTools\Responders;

/**
 *
 * Responder Interface
 * @author Jose Luis Fonseca
 */
interface ResponderInterface {
    
    /**
     * Will respond with a json object of a single resource
     * @param Object $item
     */
    public function item($item);
    
    /**
     * Will respond with a formated collection of resources and meta data
     * @param Object $collection
     */
    public function collection($collection);
    
    /**
     * Will respond with status 400 and validation errors
     * @param Object $validator
     */
    public function validationError($validator);
    
    /**
     * Will respond with 404, whenever a page or resource is not found
     */
    public function resourceNotFound();
    
    /**
     * Will respond with 204 since there is no error but there is also no
     * content found for the resource
     */
    public function resourceNotAvailable();
    
    /**
     * Will respond with a status 500, provides an error code and 
     * error description
     * @param String $errorCode
     * @param String $errorDescription
     */
    public function appError($errorCode, $errorDescription);
    
}
