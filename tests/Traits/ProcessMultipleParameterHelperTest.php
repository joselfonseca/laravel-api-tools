<?php

namespace Tests\Unit\Traits;

use Faker\Factory as Faker;
use Joselfonseca\LaravelApiTools\Tests\TestCase;
use Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake;

class ProcessMultipleParameterHelperTest extends TestCase
{
    protected $_faker;

    public function setUp() : void
    {
        parent::setUp();
        $this->_faker = Faker::create();
    }

    public function test_it_returns_an_array_with_single_element_because_it_only_was_sended_one_parameter()
    {
        $uuid1 = $this->_faker->uuid;

        $parameter = $uuid1;

        $service = new ServiceFake;

        $result = $service->processParameter($parameter);

        $expected = [
            $uuid1,
        ];

        $this->assertEquals($expected, $result);
    }

    public function test_it_returns_an_array_with_two_elements_because_it_only_was_sended_two_parameters()
    {
        $uuid1 = $this->_faker->uuid;
        $uuid2 = $this->_faker->uuid;

        $parameter = $uuid1 . ',' . $uuid2;

        $service = new ServiceFake;

        $result = $service->processParameter($parameter);

        $expected = [
            $uuid1,
            $uuid2,
        ];

        $this->assertEquals($expected, $result);
    }

    public function test_it_returns_empty_array_because_empty_parameters_was_sended()
    {
        $parameter = '';

        $service = new ServiceFake;

        $result = $service->processParameter($parameter);

        $this->assertEquals([], $result);
    }

    public function test_it_returns_empty_array_because_coma_in_parameters_was_sended()
    {
        $parameter = ',';

        $service = new ServiceFake;

        $result = $service->processParameter($parameter);

        $this->assertEquals([], $result);
    }
}