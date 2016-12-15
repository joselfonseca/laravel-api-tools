<?php

namespace Joselfonseca\LaravelApiTools\Tests\Fakes;

use League\Fractal\TransformerAbstract;

/**
 * Class TransformerStub
 * @package Joselfonseca\LaravelApiTools\Tests\Stubs
 */
class TransformerFake extends TransformerAbstract
{

    /**
     * @param ModelFake $model
     * @return array
     */
    public function transform(ModelFake $model)
    {
        return $model->toArray();
    }

}