<?php

namespace Joselfonseca\LaravelApiTools\Tests\Fakes;

use League\Fractal\Serializer\DataArraySerializer;
use Joselfonseca\LaravelApiTools\Contracts\FractalAble;
use Joselfonseca\LaravelApiTools\Traits\FilterableTrait;
use Joselfonseca\LaravelApiTools\Contracts\ValidateAble;
use Joselfonseca\LaravelApiTools\Traits\FractalAbleTrait;
use Joselfonseca\LaravelApiTools\Traits\ValidateAbleTrait;
use Joselfonseca\LaravelApiTools\Traits\OrderQueryResultHelper;
use Joselfonseca\LaravelApiTools\Traits\ProcessMultipleParameterHelper;

/**
 * Class ServiceStub
 * @package Joselfonseca\LaravelApiTools\Tests\Stubs
 */
class ServiceFake implements FractalAble, ValidateAble
{

    use FractalAbleTrait, ValidateAbleTrait, ProcessMultipleParameterHelper, FilterableTrait, OrderQueryResultHelper;

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
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function setSerializer()
    {
        return app(DataArraySerializer::class);
    }

    /**
     * @param array $data
     */
    public function create(array $data = [])
    {
        $this->runValidator($data, ['name' => 'required'], []);
    }

    /**
     * @return array
     */
    public function getFilterableFields()
    {
        return [
            'name' => 'end',
            'email' => 'partial',
            'uuid' => 'exact',
        ];
    }

}