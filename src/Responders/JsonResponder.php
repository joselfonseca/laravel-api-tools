<?php


namespace Joselfonseca\LaravelApiTools\Responders;

use Joselfonseca\LaravelApiTools\Interfaces\ResponderInterface;
use \League\Fractal\Manager;
use Illuminate\Http\Response;

/**
 * Default implementation of the Responder interfase
 *
 * @author Jose Luis Fonseca
 */
class JsonResponder implements ResponderInterface{
    
    private $manager;
    private $response;
    private $laravelResponse;
    
    public function __construct() {
        $this->manager = new Manager;
        $this->laravelResponse = new Response;
    }
    /**
     * set the common headers for the response and return it
     */
    private function respond(){
        $this->response->header('Access-Control-Allow-Origin', '*');
        $this->response->header('Content-Type', 'application/json');
        return $this->response;
    }
    /**
     * Simple json from a simple array
     * @param array $data
     * @param integer $responseCode
     * @return Illuminate\Support\Facades\Response
     */
    public function simpleJson($data = [], $responseCode = 200){
        $this->response = $this->laravelResponse->setContent(json_encode($data))->setStatusCode($responseCode);
        return $this->respond();
    }
    /**
     * Use it or error responses, after a try catch or App::error
     * @param string $errorCode
     * @param string $errorDescription
     * @return Illuminate\Support\Facades\Response
     */
    public function appError($errorCode = "Exception", $errorDescription = "The app encounter an error not defined") {
        $this->response = $this->laravelResponse->setContent(json_encode(['ErrorCode' => $errorCode, 'ErrorDescription' => $errorDescription]))->setStatusCode(500);
        return $this->respond();
    }
    /**
     * Get a fractal item or collection and parse it's includes as seccond parameter.
     * @param Fractal Item $item
     * @param array $includes
     * @return Illuminate\Support\Facades\Response
     */
    public function item($item, $includes = [], $extraData = []) {
        $manager = $this->manager->parseIncludes($includes);
        $data = $manager->createData($item)->toArray();
        $finalData = array_merge($extraData, $data);
        $this->response = $this->laravelResponse->setContent(json_encode($finalData))->setStatusCode(200);
        return $this->respond();
    }
    /**
     * If a resource is not found because the route does not exsist deliver a 404
     * @param string $message
     * @return Illuminate\Support\Facades\Response
     */
    public function resourceNotFound($message = "We could not find what you were looking for") {
        $this->response = $this->laravelResponse->setContent(json_encode(['message' => $message]))->setStatusCode(404);
        return $this->respond();
    }
    /**
     * Pass the validator and it will build the response with the error messages
     * @param Illuminate\Validation\Validator $validator
     * @return Illuminate\Support\Facades\Response
     */
    public function validationError($validator) {
        $messages = $validator->messages();
        $this->response = $this->laravelResponse->setContent(json_encode(['ErrorCode' => 'ValidationFail', 'ErrorDescription' => 'The input validation failed', 'errors' => $messages->all()]))->setStatusCode(400);
        return $this->respond();
    }
    /**
     * If there is no access to the resource, respond with a 401
     * @param type $message
     * @return type
     */
    public function unauthorized($message = "You dont have permissions for this resource", $errorCode = "AuthException"){
        $this->response = $this->laravelResponse->setContent(json_encode(['message' => $message, 'ErrorCode' => $errorCode]))->setStatusCode(401);
        return $this->respond();
    }

}
