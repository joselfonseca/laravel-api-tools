<?php

namespace Joselfonseca\LaravelApiTools\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Joselfonseca\LaravelApiTools\Providers\LaravelApiToolsServiceProvider;


/**
 * Class TestCase
 * @package Joselfonseca\LaravelApiTools\Tests
 */
class TestCase extends OrchestraTestCase
{

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [LaravelApiToolsServiceProvider::class];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Uuid' => \Webpatser\Uuid\Uuid::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * @test
     */
    public function it_passes_to_avoid_phpunit_warning()
    {
        $this->assertTrue(true);
    }

}