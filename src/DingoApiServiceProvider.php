<?php

namespace Joselfonseca\LaravelApiTools;

use Dingo\Api\Provider\LaravelServiceProvider;

/**
 * Class DingoApiServiceProvider
 * This is a provider as a temp fix for Dingo API please see https://github.com/dingo/api/pull/776
 * @package Joselfonseca\LaravelApiTools
 */
class DingoApiServiceProvider extends LaravelServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->setupConfig();
        parent::register();
    }

}