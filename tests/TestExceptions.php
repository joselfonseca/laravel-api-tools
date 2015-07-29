<?php


class TestExceptions extends Orchestra\Testbench\TestCase{

    protected function getPackageProviders($app)
    {
        return ['Joselfonseca\LaravelApiTools\LaravelApiToolsServiceProvider'];
    }

    /**
     * @expectedException     Joselfonseca\LaravelApiTools\Exceptions\AclException
     */
    public function testAclException()
    {
        throw new Joselfonseca\LaravelApiTools\Exceptions\AclException();
    }

    /**
     * @expectedException     Joselfonseca\LaravelApiTools\Exceptions\ApiModelNotFoundException
     */
    public function testApiModelNotFoundException()
    {
        throw new Joselfonseca\LaravelApiTools\Exceptions\ApiModelNotFoundException();
    }

}