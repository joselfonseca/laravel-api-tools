<?php

namespace Joselfonseca\LaravelApiTools\Traits;

/**
 * Description of DingoResponderTrait
 *
 * @author josefonseca
 */
trait DingoResponderTrait
{

    private $responder;

    public function __construct()
    {
        $this->responder = app('Dingo\Api\Http\Response\Factory');
    }
}