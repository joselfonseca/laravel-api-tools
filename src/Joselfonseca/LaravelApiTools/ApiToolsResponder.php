<?php

namespace Joselfonseca\LaravelApiTools;

/**
 * This class will trigger common tasks used in the API Development responses
 *
 * @author Jose Luis Fonseca
 */
class ApiToolsResponder {
    
    /**
     * Respond with a simple array to a simple JSON
     * @param array $data
     * @param integer $responseCode
     * @return Illuminate\Support\Facades\Response
     */
    public static function simpleJson($data = [], $responseCode = 200){
        $responder = \App::make('JsonResponder');
        return $responder->simpleJson($data, $responseCode);
    }

    /**
     * Respond with a Fractal Item or collection
     * @param object $item or $collection fractal
     * @param array $includes
     * @param array $extra extra keys to insert in the response
     * @return Illuminate\Support\Facades\Response
     */
    public static function Fractal($item, $includes = [], $extra = []){
        $responder = \App::make('JsonResponder');
        return $responder->item($item, $includes, $extra);
    }
    /**
     * Whenever there is an error in the app, use this method to return a
     * json response to that error.
     * @param string $errorCode
     * @param string $errorDescription
     * @return Illuminate\Support\Facades\Response
     */
    public static function AppError($errorCode = "Exception", $errorDescription = "The app encounter an error not defined"){
        $responder = \App::make('JsonResponder');
        return $responder->appError($errorCode, $errorDescription);
    }
    /**
     * Whenever there is a route exeption, or a really 404, this method can be 
     * use to returna 404 with a json.
     * @param string $message
     * @return Illuminate\Support\Facades\Response
     */
    public static function resourceNotFound($message = "We could not find what you were looking for"){
        $responder = \App::make('JsonResponder');
        return $responder->resourceNotFound($message);
    }
    /**
     * Pass the validator and it will build the response with the error messages
     * @param Illuminate\Validation\Validator $validator
     * @return Illuminate\Support\Facades\Response
     */
    public static function validationError($validator){
        $responder = \App::make('JsonResponder');
        return $responder->validationError($validator);
    }
    /**
     * If a resource is access without permision, use this method to return the 
     * Auth exception
     * @param string $message
     * @param string $errorCode
     * @return Illuminate\Support\Facades\Response
     */
    public static function unauthorizedAccess($message = "You dont have permissions for this resource", $errorCode = "AuthException"){
        $responder = \App::make('JsonResponder');
        return $responder->unauthorized($message = "You dont have permissions for this resource", $errorCode = "AuthException");
    }
    
}
