<?php

namespace Joselfonseca\LaravelApiTools\Tests\Unit\Traits;

use Mockery;
use Faker\Factory as Faker;
use Joselfonseca\LaravelApiTools\Tests\TestCase;
use Joselfonseca\LaravelApiTools\Tests\Fakes\ModelFake;
use Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake;

class FilterableTraitTest extends TestCase
{
    protected $_faker;

    public function setUp()
    {
        parent::setUp();
        $this->_faker = Faker::create();
    }

	public function testItSetsFieldsValuesAndRulesToApply()
    {
        $model = new ModelFake;

        $filterableFields = [
            'name' => 'end',
            'email' => 'partial',
            'uuid' => 'exact',
        ];

        $service = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake[getFilterableFields]');

        $service->shouldReceive('getFilterableFields')
            ->andReturn($filterableFields);

        $requestFields = [
            'name' => $this->_faker->name,
            'email' => $this->_faker->email,
        ];

        $service->addFilter($requestFields);

        $addedFilters = $service->getFilters();

        $expected = [
            'name' => 'end',
            'email' => 'partial',
        ];

        $this->assertEquals($expected, $addedFilters);
    }

    public function testItNotSetsFieldsValuesAndRulesBecauseRequestFieldsWhereNotDefinedInFilterableFields()
    {
        $model = new ModelFake;

        $filterableFields = [
            'name' => 'end',
            'email' => 'partial',
            'uuid' => 'exact',
        ];

        $service = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake[getFilterableFields]');

        $service->shouldReceive('getFilterableFields')
            ->andReturn($filterableFields);

        $requestFields = [
            'work' => $this->_faker->name,
            'place' => $this->_faker->email,
        ];

        $service->addFilter($requestFields);

        $addedFilters = $service->getFilters();

        $this->assertEquals([], $addedFilters);
    }

    public function testItNotSetsFVROfFieldsThatHasEmptyOrNullValues()
    {
        $model = new ModelFake;

        $filterableFields = [
            'name' => 'end',
            'email' => 'partial',
            'uuid' => 'exact',
        ];

        $service = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake[getFilterableFields]');

        $service->shouldReceive('getFilterableFields')
            ->andReturn($filterableFields);

        $requestFields = [
            'name' => '',
            'email' => $this->_faker->email,
            'uuid' => null,
        ];

        $service->addFilter($requestFields);

        $addedFilters = $service->getFilters();

        $expected = [
            'email' => 'partial',
        ];

        $this->assertEquals($expected, $addedFilters);
    }

    public function testItSetsFVROfFieldsThatHasValueAs0()
    {
        $model = new ModelFake;

        $filterableFields = [
            'name' => 'end',
            'email' => 'partial',
            'uuid' => 'exact',
        ];

        $service = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake[getFilterableFields]');

        $service->shouldReceive('getFilterableFields')
            ->andReturn($filterableFields);

        $requestFields = [
            'name' => '0',
            'email' => $this->_faker->email,
            'uuid' => null,
        ];

        $service->addFilter($requestFields);

        $addedFilters = $service->getFilters();

        $expected = [
            'name' => 'end',
            'email' => 'partial',
        ];

        $this->assertEquals($expected, $addedFilters);
    }

    public function testParseRuleToBeApplied()
    {
        $service = new ServiceFake;

        $rule = 'exact';

        list($operator, $statement, $condition) = $service->parseRule($rule);

        $this->assertEquals('exact', $operator);
        $this->assertEquals('and', $statement);
        $this->assertEquals('=', $condition);
    }

    public function testParseRuleToBeAppliedWithOrStatement()
    {
        $service = new ServiceFake;

        $rule = 'start|or';

        list($operator, $statement, $condition) = $service->parseRule($rule);

        $this->assertEquals('start', $operator);
        $this->assertEquals('or', $statement);
        $this->assertEquals('like', $condition);
    }

    public function testParseEndRuleToBeAppliedWithAndStatement()
    {
        $service = new ServiceFake;

        $rule = 'end|and';

        list($operator, $statement, $condition) = $service->parseRule($rule);

        $this->assertEquals('end', $operator);
        $this->assertEquals('and', $statement);
        $this->assertEquals('like', $condition);
    }

    public function testParsePartialRuleToBeAppliedWithAndStatement()
    {
        $service = new ServiceFake;

        $rule = 'partial';

        list($operator, $statement, $condition) = $service->parseRule($rule);

        $this->assertEquals('partial', $operator);
        $this->assertEquals('and', $statement);
        $this->assertEquals('like', $condition);
    }

    public function testParseCustomConditionRuleToBeAppliedWithDefaultAndStatement()
    {
        $service = new ServiceFake;

        $rule = 'condition:>=';

        list($operator, $statement, $condition) = $service->parseRule($rule);

        $this->assertEquals('custom', $operator);
        $this->assertEquals('and', $statement);
        $this->assertEquals('>=', $condition);
    }

    public function testParseOtherCustomConditionRuleToBeAppliedWithOrStatement()
    {
        $service = new ServiceFake;

        $rule = 'condition:<=|date';

        list($operator, $statement, $condition) = $service->parseRule($rule);

        $this->assertEquals('custom', $operator);
        $this->assertEquals('date', $statement);
        $this->assertEquals('<=', $condition);
    }

    public function testAppliesExactFilterRulesToQuery()
    {
        $addedFilters = [
            'name' => 'end',
            'email' => 'partial',
        ];

        $requestFields = [
            'name' => $this->_faker->name,
            'email' => $this->_faker->email,
        ];

        $model = Mockery::mock('ModelFake');

        $model->shouldReceive('where')
            ->twice()
            ->andReturn(Mockery::self());

        $service = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake[getFilters]');

        $service->shouldReceive('getFilters')
            ->andReturn($addedFilters);

        $query = $service->applyFilters($model, $requestFields);
    }

    public function testAppliesStartFilterRuleToQuery()
    {
        $addedFilters = [
            'name' => 'start',
        ];

        $requestFields = [
            'name' => $this->_faker->name,
        ];

        $model = Mockery::mock('ModelFake');

        $model->shouldReceive('where')
            ->with('name', 'like', $requestFields['name'] . '%')
            ->once()
            ->andReturn(Mockery::self());

        $service = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake[getFilters]');

        $service->shouldReceive('getFilters')
            ->andReturn($addedFilters);

        $query = $service->applyFilters($model, $requestFields);
    }

    public function testAppliesEndFilterRuleToQuery()
    {
        $addedFilters = [
            'name' => 'end',
        ];

        $requestFields = [
            'name' => $this->_faker->name,
        ];

        $model = Mockery::mock('ModelFake');

        $model->shouldReceive('where')
            ->with('name', 'like', '%' . $requestFields['name'])
            ->once()
            ->andReturn(Mockery::self());

        $service = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake[getFilters]');

        $service->shouldReceive('getFilters')
            ->andReturn($addedFilters);

        $query = $service->applyFilters($model, $requestFields);
    }

    public function testAppliesPartialFilterRuleToQuery()
    {
        $addedFilters = [
            'name' => 'partial',
        ];

        $requestFields = [
            'name' => $this->_faker->name,
        ];

        $model = Mockery::mock('ModelFake');

        $model->shouldReceive('where')
            ->with('name', 'like', '%' . $requestFields['name'] . '%')
            ->once()
            ->andReturn(Mockery::self());

        $service = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake[getFilters]');

        $service->shouldReceive('getFilters')
            ->andReturn($addedFilters);

        $query = $service->applyFilters($model, $requestFields);
    }

    public function testAppliesCustomOperatorToQuery()
    {
        $addedFilters = [
            'name' => 'condition:>=',
        ];

        $requestFields = [
            'name' => $this->_faker->name,
        ];

        $model = Mockery::mock('ModelFake');

        $model->shouldReceive('where')
            ->with('name', '>=', $requestFields['name'])
            ->once()
            ->andReturn(Mockery::self());

        $service = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake[getFilters]');

        $service->shouldReceive('getFilters')
            ->andReturn($addedFilters);

        $query = $service->applyFilters($model, $requestFields);
    }

    public function testAppliesOtherCustomOperatorToQuery()
    {
        $addedFilters = [
            'name' => 'condition:<=',
        ];

        $requestFields = [
            'name' => $this->_faker->name,
        ];

        $model = Mockery::mock('ModelFake');

        $model->shouldReceive('where')
            ->with('name', '<>', $requestFields['name'])
            ->once()
            ->andReturn(Mockery::self());

        $service = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake[getFilters]');

        $service->shouldReceive('getFilters')
            ->andReturn($addedFilters);

        $query = $service->applyFilters($model, $requestFields);
    }

    public function testItAppliesOrStatementToQuery()
    {
        $addedFilters = [
            'name' => 'or',
        ];

        $requestFields = [
            'name' => $this->_faker->name,
        ];

        $model = Mockery::mock('ModelFake');

        $model->shouldReceive('orWhere')
            ->with('name', '=', $requestFields['name'])
            ->once()
            ->andReturn(Mockery::self());

        $service = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake[getFilters]');

        $service->shouldReceive('getFilters')
            ->andReturn($addedFilters);

        $query = $service->applyFilters($model, $requestFields);
    }

    public function testItAppliesDateStatementToQuery()
    {
        $addedFilters = [
            'created_at' => 'ordate|start',
        ];

        $requestFields = [
            'created_at' => $this->_faker->date('Y-m-d', 'now'),
        ];

        $model = Mockery::mock('ModelFake');

        $model->shouldReceive('orWhereDate')
            ->with('created_at', 'like', $requestFields['created_at'] . '%')
            ->once()
            ->andReturn(Mockery::self());

        $service = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake[getFilters]');

        $service->shouldReceive('getFilters')
            ->andReturn($addedFilters);

        $query = $service->applyFilters($model, $requestFields);
    }

    public function testItAppliesPartialDateStatementToQuery()
    {
        $addedFilters = [
            'created_at' => 'date|partial',
        ];

        $requestFields = [
            'created_at' => $this->_faker->date('Y-m-d', 'now'),
        ];

        $model = Mockery::mock('ModelFake');

        $model->shouldReceive('whereDate')
            ->with('created_at', 'like', '%' . $requestFields['created_at'] . '%')
            ->once()
            ->andReturn(Mockery::self());

        $service = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake[getFilters]');

        $service->shouldReceive('getFilters')
            ->andReturn($addedFilters);

        $query = $service->applyFilters($model, $requestFields);
    }

    public function testItAppliesHasStatementToQuery()
    {
        $addedFilters = [
            'number' => 'has|condition:<',
        ];

        $requestFields = [
            'number' => $this->_faker->randomDigit,
        ];

        $model = Mockery::mock('ModelFake');

        $model->shouldReceive('has')
            ->with('number', '<', $requestFields['number'])
            ->once()
            ->andReturn(Mockery::self());

        $service = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake[getFilters]');

        $service->shouldReceive('getFilters')
            ->andReturn($addedFilters);

        $query = $service->applyFilters($model, $requestFields);
    }

    public function testItAppliesMultiplesStatementsToQuery()
    {
        $addedFilters = [
            'number' => 'has|condition:>',
            'word' => 'start',
            'phonenumber' => 'exact|or',
        ];

        $requestFields = [
            'number' => $this->_faker->randomDigit,
            'word' => $this->_faker->word,
            'phonenumber' => $this->_faker->phoneNumber,
        ];

        $model = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ModelFake');

        $model->shouldReceive('has')
            ->with('number', '>', $requestFields['number'])
            ->once()
            ->andReturn(Mockery::self());

        $model->shouldReceive('where')
            ->with('word', 'like', $requestFields['word'] . '%')
            ->once()
            ->andReturn(Mockery::self());

        $model->shouldReceive('orWhere')
            ->with('phonenumber', '=', $requestFields['phonenumber'])
            ->once()
            ->andReturn(Mockery::self());

        $service = Mockery::mock('Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake[getFilters]');

        $service->shouldReceive('getFilters')
            ->andReturn($addedFilters);

        $query = $service->applyFilters($model, $requestFields);
    }
}