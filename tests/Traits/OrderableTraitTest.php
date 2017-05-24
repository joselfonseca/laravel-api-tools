<?php

namespace Tests\Unit\Traits;

use Mockery;
use Faker\Factory as Faker;
use Joselfonseca\LaravelApiTools\Tests\TestCase;
use Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake;

class OrderQueryResultHelperTest extends TestCase
{
    protected $_faker;

    protected function setUp()
    {
        parent::setUp();
        $this->_faker = Faker::create();
    }

    protected function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testItParsesOrderByParametersFromRequestDefaultAscDirection()
    {
        $service = new ServiceFake;

        $request = [
        'orderBy' => 'full_name',
        'full_name' => $this->_faker->word,
        ];

        $expected = [
        'full_name' => 'asc',
        ];

        $this->assertTrue($service->processOrderingRules($request));

        $orderingRules = $service->getOrderingRules();

        $this->assertEquals($expected, $orderingRules);
    }

    public function testItParsesOrderByParametersFromRequestAscDirection()
    {
        $service = new ServiceFake;

        $request = [
        'orderBy' => 'full_name:asc',
        'full_name' => $this->_faker->word,
        ];

        $expected = [
        'full_name' => 'asc',
        ];

        $this->assertTrue($service->processOrderingRules($request));

        $orderingRules = $service->getOrderingRules();

        $this->assertEquals($expected, $orderingRules);
    }

    public function testItParsesOrderByParametersFromRequestDescDirection()
    {
        $service = new ServiceFake;

        $request = [
        'orderBy' => 'full_name:desc',
        'full_name' => $this->_faker->word,
        ];

        $expected = [
        'full_name' => 'desc',
        ];

        $this->assertTrue($service->processOrderingRules($request));

        $orderingRules = $service->getOrderingRules();

        $this->assertEquals($expected, $orderingRules);
    } 

    public function testItParsesParametersFromRequestWithoutOrderByColumn()
    {
        $service = new ServiceFake;

        $request = [
        'full_name' => $this->_faker->word,
        ];

        $this->assertFalse($service->processOrderingRules($request));

        $orderingRules = $service->getOrderingRules();

        $this->assertEquals([], $orderingRules);
    }

    public function testItParsesParametersGetFromRequestWithEmptyOrderByColumn()
    {
        $service = new ServiceFake;

        $request = [
        'orderBy' => '',
        'full_name' => $this->_faker->word,
        ];

        $this->assertFalse($service->processOrderingRules($request));

        $orderingRules = $service->getOrderingRules();

        $this->assertEquals([], $orderingRules);
    }

    public function testItParsesParametersFromRequestWithTwoOrderByRules()
    {
        $service = new ServiceFake;

        $column1 = $this->_faker->word;
        $column2 = $this->_faker->word;

        $request = [
        'orderBy' => $column1 . ',' . $column2,
        ];

        $expected = [
        $column1 => 'asc',
        $column2 => 'asc',
        ];

        $this->assertTrue($service->processOrderingRules($request));

        $orderingRules = $service->getOrderingRules();

        $this->assertEquals($expected, $orderingRules);
    }

    public function testItParsesParametersFromRequestWithTwoOrderByAndDirectionRules()
    {
        $service = new ServiceFake;

        $column1 = $this->_faker->word;
        $column2 = $this->_faker->word;

        $request = [
        'orderBy' => $column1 . ':asc,' . $column2 . ':desc',
        ];

        $expected = [
        $column1 => 'asc',
        $column2 => 'desc',
        ];

        $this->assertTrue($service->processOrderingRules($request));

        $orderingRules = $service->getOrderingRules();

        $this->assertEquals($expected, $orderingRules);
    }

    public function testItParsesOrderByParametersFromRequestWithDirectionEmpty()
    {
        $service = new ServiceFake;

        $column1 = $this->_faker->word;

        $request = [
        'orderBy' => $column1 . ':',
        ];

        $expected = [
        $column1 => 'asc',
        ];

        $this->assertTrue($service->processOrderingRules($request));

        $orderingRules = $service->getOrderingRules();

        $this->assertEquals($expected, $orderingRules);
    }

    public function testItParsesParametersFromRequestWithTwoOrderByButTheSecondRuleIsEmpty()
    {
        $service = new ServiceFake;

        $column1 = $this->_faker->word;
        $column2 = $this->_faker->word;

        $request = [
        'orderBy' => $column1 . ',',
        ];

        $expected = [
        $column1 => 'asc',
        ];

        $this->assertTrue($service->processOrderingRules($request));

        $orderingRules = $service->getOrderingRules();

        $this->assertEquals($expected, $orderingRules);
    }

    public function testItParsesParametersFromRequestButRuleOnlyContainsDoubleDots()
    {
        $service = new ServiceFake;

        $column1 = $this->_faker->word;

        $request = [
        'orderBy' => ':',
        ];

        $result = $service->processOrderingRules($request);

        $this->assertTrue($service->processOrderingRules($request));

        $orderingRules = $service->getOrderingRules();

        $this->assertEquals([], $orderingRules);
    }

    public function testItParsesParametersFromRequestButRuleOnlyContainsDoubleDotsAndSecondColumnIsValid()
    {
        $service = new ServiceFake;

        $column1 = $this->_faker->word;
        $column2 = $this->_faker->word;

        $request = [
        'orderBy' => ':,' . $column2 . ':desc',
        ];

        $result = $service->processOrderingRules($request);

        $expected = [
        $column2 => 'desc',
        ];

        $this->assertTrue($service->processOrderingRules($request));

        $orderingRules = $service->getOrderingRules();

        $this->assertEquals($expected, $orderingRules);
    }

    public function testItValidatesOrderByDirectionOnlyCouldBeAscOrDescIfIsNotAscIsSettedByDefault()
    {
        $service = new ServiceFake;

        $column1 = $this->_faker->word;

        $request = [
        'orderBy' => $column1 . ':' . $this->_faker->word,
        ];

        $result = $service->processOrderingRules($request);

        $expected = [
        $column1 => 'asc',
        ];

        $this->assertTrue($service->processOrderingRules($request));

        $orderingRules = $service->getOrderingRules();

        $this->assertEquals($expected, $orderingRules);
    }

    public function testItapplyOrderingRulesDefinedInRequest()
    {
        $column1 = $this->_faker->word;

        $orderingRules = [
        $column1 => 'asc',
        ];

        $model = Mockery::mock('ModelFake');

        $model->shouldReceive('orderBy')
        ->with($column1, $orderingRules[$column1])
        ->once()
        ->andReturn(Mockery::self());

        $service = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake[getOrderingRules]');

        $service->shouldReceive('getOrderingRules')
        ->andReturn($orderingRules);

        $result = $service->applyOrderingRules($model);

        $this->assertTrue($result instanceof \ModelFake);
    }

    public function testItapplyMultipleOrderingRulesDefinedInRequest()
    {
        $column1 = $this->_faker->word;
        $column2 = $this->_faker->word;
        $column3 = $this->_faker->word;

        $orderingRules = [
        $column1 => 'asc',
        $column2 => 'asc',
        $column3 => 'desc',
        ];

        $model = Mockery::mock('ModelFake');

        $model->shouldReceive('orderBy')
        ->with($column1, $orderingRules[$column1])
        ->once()
        ->andReturn(Mockery::self());

        $model->shouldReceive('orderBy')
        ->with($column2, $orderingRules[$column2])
        ->once()
        ->andReturn(Mockery::self());

        $model->shouldReceive('orderBy')
        ->with($column3, $orderingRules[$column3])
        ->once()
        ->andReturn(Mockery::self());

        $service = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake[getOrderingRules]');

        $service->shouldReceive('getOrderingRules')
        ->andReturn($orderingRules);

        $result = $service->applyOrderingRules($model);

        $this->assertTrue($result instanceof \ModelFake);
    }

    public function testItNeverApplyEmptyOrderingRules()
    {
        $orderingRules = [];

        $model = Mockery::mock('ModelFake');

        $model->shouldReceive('orderBy')
        ->never();

        $service = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake[getOrderingRules]');

        $service->shouldReceive('getOrderingRules')
        ->andReturn($orderingRules);

        $result = $service->applyOrderingRules($model);

        $this->assertTrue($result instanceof \ModelFake);
    }

    public function testItApplySortByRules()
    {
        $service = new ServiceFake;
        
        $column1 = $this->_faker->word;
        $column2 = $this->_faker->word;
        $column3 = $this->_faker->word;

        $request = [
        'orderBy' => $column1 . ',' . $column2 . ':asc,' . $column3 . ':desc',
        ];

        $model = Mockery::mock('ModelFake');

        $model->shouldReceive('orderBy')
        ->with($column1, 'asc')
        ->once()
        ->andReturn(Mockery::self());

        $model->shouldReceive('orderBy')
        ->with($column2, 'asc')
        ->once()
        ->andReturn(Mockery::self());

        $model->shouldReceive('orderBy')
        ->with($column3, 'desc')
        ->once()
        ->andReturn(Mockery::self());

        $service->processOrderingRules($request);
        $service->applyOrderingRules($model);

    }
}