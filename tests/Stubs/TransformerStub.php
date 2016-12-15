<?php

namespace Joselfonseca\LaravelApiTools\Tests\Stubs;

use League\Fractal\TransformerAbstract;

/**
 * Class TransformerStub
 * @package Joselfonseca\LaravelApiTools\Tests\Stubs
 */
class TransformerStub extends TransformerAbstract
{

    /**
     * @param ModelStub $model
     * @return array
     */
    public function transform(ModelStub $model)
    {
        return $model->toArray();
    }

}