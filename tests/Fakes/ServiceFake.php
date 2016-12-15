<?php

namespace Joselfonseca\LaravelApiTools\Tests\Fakes;

use Joselfonseca\LaravelApiTools\Contracts\FractalAble;
use Joselfonseca\LaravelApiTools\Contracts\ValidateAble;
use Joselfonseca\LaravelApiTools\Traits\FractalAbleTrait;
use Joselfonseca\LaravelApiTools\Traits\ValidateAbleTrait;

/**
 * Class ServiceStub
 * @package Joselfonseca\LaravelApiTools\Tests\Stubs
 */
class ServiceFake implements FractalAble, ValidateAble
{

    use FractalAbleTrait, ValidateAbleTrait;

    /**
     * @var string
     */
    protected $resourceKey = 'people';

    /**
     * @return TransformerFake|mixed
     */
    public function setTransformer()
    {
        return app(TransformerFake::class);
    }

    /**
     * @param array $data
     */
    public function create(array $data = [])
    {
        $this->runValidator($data, ['name' => 'required'], []);
    }

}