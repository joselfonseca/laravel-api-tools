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

        ];
    }

}