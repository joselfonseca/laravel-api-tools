<?php

namespace Joselfonseca\LaravelApiTools\Interfaces;

/**
 *
 * Responder Interface
 * @author Jose Luis Fonseca
 */
interface ResponderInterface {
    
    /**
     * respond with a simple json from a simple array
     * @param integer $responseCode
     * @param array $data
     */
    public function simpleJson($data = [], $responseCode = 200);
    
    /**
     * Will respond with a json object of a single resource
     * @param Object $item
     */
    public function item($item, $includes = [], $extraData = []);
    
    /**
     * Will respond with status 400 and validation errors
     * @param Object $validator
     */
    public function validationError($validator);
    
    /**
     * Will respond with 404, whenever a page or resource is not found
     */
    public function resourceNotFound($message = "");
    
    /**
     * Will respond with a status 500, provides an error code and 
     * error description
     * @param String $errorCode
     * @param String $errorDescription
     */
    public function appError($errorCode, $errorDescription);
    
    /**
     * Will respond with a message and a 401 for no access
     * @param type $message
     */
    public function unauthorized($message = "You dont have permissions for this resource", $errorCode = "AuthException");

    /**
     * Will respond with a status code 204 for no content
     */
    public function responseNoContent();
    
}
