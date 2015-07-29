<?php

namespace Joselfonseca\LaravelApiTools\Tests;

use \Mockery as m;

class TestExceptions extends Boot{

    /**
     * @expectedException     Joselfonseca\LaravelApiTools\Exceptions\AclException
     */
    public function testAclException()
    {
        throw new \Joselfonseca\LaravelApiTools\Exceptions\AclException();
    }

    /**
     * @expectedException     Joselfonseca\LaravelApiTools\Exceptions\ApiModelNotFoundException
     */
    public function testApiModelNotFoundException()
    {
        throw new \Joselfonseca\LaravelApiTools\Exceptions\ApiModelNotFoundException();
    }

    /**
     * @expectedException     Joselfonseca\LaravelApiTools\Exceptions\AuthorizationException
     */
    public function testAuthorizationException()
    {
        throw new \Joselfonseca\LaravelApiTools\Exceptions\AuthorizationException();
    }

    /**
     * @expectedException     Joselfonseca\LaravelApiTools\Exceptions\InvalidArgumentException
     */
    public function testInvalidArgumentException()
    {
        throw new \Joselfonseca\LaravelApiTools\Exceptions\InvalidArgumentException();
    }

    /**
     * @expectedException     Joselfonseca\LaravelApiTools\Exceptions\ValidationException
     */
    public function testValidationException()
    {
        $validator = m::mock('validator')->shouldReceive('errors')->andReturn([])->mock();
        throw new \Joselfonseca\LaravelApiTools\Exceptions\ValidationException($validator);
    }

    /**
     * Mockery
     */
    public function tearDown()
    {
        m::close();
    }

}