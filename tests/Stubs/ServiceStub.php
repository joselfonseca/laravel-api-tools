<?php

namespace Joselfonseca\LaravelApiTools\Tests\Stubs;

use Joselfonseca\LaravelApiTools\Contracts\FractalAble;
use Joselfonseca\LaravelApiTools\Traits\FractalAbleTrait;

/**
 * Class ServiceStub
 * @package Joselfonseca\LaravelApiTools\Tests\Stubs
 */
class ServiceStub implements FractalAble
{

    use FractalAbleTrait;

    /**
     * @var string
     */
    protected $resourceKey = 'people';

    /**
     * @return TransformerStub|mixed
     */
    public function setTransformer()
    {
        return app(TransformerStub::class);
    }

}