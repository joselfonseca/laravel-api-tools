<?php

namespace Joselfonseca\LaravelApiTools\Tests\Stubs;

use League\Fractal\TransformerAbstract;

class TransformerStub extends TransformerAbstract{

    public function transform($array = ['foo' => 'bar'])
    {
        return $array;
    }

}