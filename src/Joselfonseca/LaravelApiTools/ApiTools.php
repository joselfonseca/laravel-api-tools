<?php

namespace Joselfonseca\LaravelApiTools;

use Joselfonseca\LaravelApiTools\Responders\Responder;

/**
 * This class will trigger common tasks used in the API Development
 *
 * @author Jose Luis Fonseca
 */
class ApiTools {
    
    /**
     * Respond with a Fractal Item
     * @param object $item
     * @param array $includes
     * @return type
     */
    public static function Item($item, $includes = []){
        $responder = new Responder;
        return $responder->item($item, $includes);
    }
    
}
