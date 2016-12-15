<?php

namespace Joselfonseca\LaravelApiTools\Tests\Stubs;

use Illuminate\Database\Eloquent\Model;
use Joselfonseca\LaravelApiTools\Traits\UuidScopeTrait;

/**
 * Class ModelStub
 * @package Joselfonseca\LaravelApiTools\Tests\Stubs
 */
class ModelStub extends Model
{

    use UuidScopeTrait;

    /**
     * @var array
     */
    protected $guarded = [];

}