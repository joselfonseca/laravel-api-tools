<?php

namespace Joselfonseca\LaravelApiTools\Tests;

class Boot extends \Orchestra\Testbench\TestCase{

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('jwt.user', 'Joselfonseca\LaravelApiTools\Tests\Stubs\UserModel');
    }

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