<?php

namespace Joselfonseca\LaravelApiTools\Tests\Fakes;

use Illuminate\Database\Eloquent\Model;
use Joselfonseca\LaravelApiTools\Traits\UuidScopeTrait;

/**
 * Class ModelStub
 * @package Joselfonseca\LaravelApiTools\Tests\Stubs
 */
class ModelFake extends Model
{

    use UuidScopeTrait;

    /**
     * @var array
     */
    protected $guarded = [];

}