<?php

namespace Joselfonseca\LaravelApiTools\Tests\Traits;

use League\Fractal\TransformerAbstract;
use Illuminate\Pagination\LengthAwarePaginator;
use Joselfonseca\LaravelApiTools\Tests\TestCase;
use League\Fractal\Serializer\SerializerAbstract;
use Joselfonseca\LaravelApiTools\Tests\Fakes\ModelFake;
use Joselfonseca\LaravelApiTools\Tests\Fakes\ServiceFake;
use Joselfonseca\LaravelApiTools\Tests\Fakes\TransformerFake;

class FractalAbleTraitTest extends TestCase
{

    protected function makeTestService()
    {
        return new ServiceFake();
    }

    /**
     * @test
     */
    public function it_returns_instance_of_transformer()
    {
        $service = $this->makeTestService();
        $this->assertInstanceOf(TransformerAbstract::class, $service->setTransformer());
        $this->assertInstanceOf(TransformerFake::class, $service->setTransformer());
    }

    /**
     * @test
     */
    public function it_returns_instance_of_serializer()
    {
        $service = $this->makeTestService();
        $this->assertInstanceOf(SerializerAbstract::class, $service->setSerializer());
    }

    /**
     * @test
     */
    public function it_transforms_a_model()
    {
        $model = new ModelFake(['id' => 1, 'name' => 'Jose Fonseca']);
        $service = $this->makeTestService();
        $transformed = $service->transform($model, ['someMeta' => ['foo' => 'bar']]);
        $this->assertArrayHasKey('data', $transformed);
        $this->assertArrayHasKey('id', $transformed['data']);
        $this->assertArrayHasKey('name', $transformed['data']);
        $this->assertEquals(1, $transformed['data']['id']);
        $this->assertEquals('Jose Fonseca', $transformed['data']['name']);
        $this->assertArrayHasKey('meta', $transformed);
        $this->assertArrayHasKey('someMeta', $transformed['meta']);
    }

    /**
     * @test
     */
    public function it_transforms_a_collection()
    {
        $collection = collect([
            new ModelFake(['id' => 1, 'name' => 'Jose Fonseca']),
            new ModelFake(['id' => 2, 'name' => 'Jose Fonseca 2']),
            new ModelFake(['id' => 3, 'name' => 'Jose Fonseca 3'])
        ]);
        $service = $this->makeTestService();
        $transformed = $service->transform($collection, ['someMeta' => ['foo' => 'bar']]);
        $this->assertArrayHasKey('data', $transformed);
        $this->assertCount(3, $transformed['data']);
        $this->assertArrayHasKey('id', $transformed['data'][0]);
        $this->assertArrayHasKey('name', $transformed['data'][0]);
        $this->assertEquals(1, $transformed['data'][0]['id']);
        $this->assertEquals('Jose Fonseca', $transformed['data'][0]['name']);
        $this->assertArrayHasKey('meta', $transformed);
        $this->assertArrayHasKey('someMeta', $transformed['meta']);
    }

    /**
     * @test
     */
    public function it_transforms_a_paginator()
    {
        $collection = collect([
            new ModelFake(['id' => 1, 'name' => 'Jose Fonseca']),
            new ModelFake(['id' => 2, 'name' => 'Jose Fonseca 2']),
            new ModelFake(['id' => 3, 'name' => 'Jose Fonseca 3'])
        ]);
        $paginator = new LengthAwarePaginator($collection->take(2), 3, 2);
        $service = $this->makeTestService();
        $transformed = $service->transform($paginator, ['someMeta' => ['foo' => 'bar']]);
        $this->assertArrayHasKey('data', $transformed);
        $this->assertCount(2, $transformed['data']);
        $this->assertArrayHasKey('id', $transformed['data'][0]);
        $this->assertArrayHasKey('name', $transformed['data'][0]);
        $this->assertEquals(1, $transformed['data'][0]['id']);
        $this->assertEquals('Jose Fonseca', $transformed['data'][0]['name']);
        $this->assertArrayHasKey('meta', $transformed);
        $this->assertArrayHasKey('someMeta', $transformed['meta']);
        $this->assertArrayHasKey('pagination', $transformed['meta']);
        $this->assertArrayHasKey('total', $transformed['meta']['pagination']);
    }

    /**
     * @test
     */
    public function it_throws_exception_if_it_cant_transform()
    {
        $this->expectException(\Joselfonseca\LaravelApiTools\Exceptions\UnTransformableResourceException::Class);
        $service = $this->makeTestService();
        $service->transform([]);
    }

}