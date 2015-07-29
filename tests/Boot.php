<?php

namespace Joselfonseca\LaravelApiTools\Tests;

class Boot extends \Orchestra\Testbench\TestCase{

    protected function getPackageProviders($app)
    {
        return ['Joselfonseca\LaravelApiTools\LaravelApiToolsServiceProvider'];
    }

    /**
     * Testing Laravel application.
     */
    public function testBoot()
    {
        $this->assertArrayHasKey('data', ['data' => 'foo']);
    }

}