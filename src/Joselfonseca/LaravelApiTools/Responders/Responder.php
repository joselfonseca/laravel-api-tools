<?php


namespace Joselfonseca\LaravelApiTools\Responders;

use Joselfonseca\LaravelApiTools\Interfaces\ResponderInterface;
use \League\Fractal\Manager;

/**
 * Default implementation of the Responder interfase
 *
 * @author Jose Luis Fonseca
 */
class Responder implements ResponderInterface{
    
    private $manager;
    
    public function __construct() {
        $this->manager = new Manager;
    }

    public function appError($errorCode, $errorDescription) {
        
    }

    public function collection($collection) {
        
    }
    /**
     * Get a fractal item and parse it's includes as seccond parameter.
     * @param Fractal Item $item
     * @param array $includes
     * @return Laravel Response
     */
    public function item($item, $includes = []) {
        $manager = $this->manager->parseIncludes($includes);
        $response = \Response::make(json_encode($manager->createData($item)->toArray()), 200);
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Content-Type', 'application/json');
        return $response;
    }

    public function resourceNotAvailable() {
        
    }

    public function resourceNotFound() {
        
    }

    public function validationError($validator) {
        
    }

}
