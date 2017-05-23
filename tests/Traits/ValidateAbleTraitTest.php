<?php

namespace Joselfonseca\LaravelApiTools\Tests\Traits;

use Joselfonseca\LaravelApiTools\Tests\TestCase;
use Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake;

/**
 * Class ValidateAbleTraitTest
 * @package Joselfonseca\LaravelApiTools\Tests\Traits
 */
class ValidateAbleTraitTest extends TestCase
{
    /**
     * @test
     * @expectedException \Dingo\Api\Exception\ResourceException
     */
    public function it_throws_validation_exception_on_invalid_input()
    {
        $service = new ServiceFake();
        $service->create([]);
    }

    /**
     * @test
     */
    public function it_passes_validation_on_valid_input()
    {
        $service = new ServiceFake();
        $service->create(['name' => 'Jose Fonseca']);
        $this->assertTrue(true);
    }

}