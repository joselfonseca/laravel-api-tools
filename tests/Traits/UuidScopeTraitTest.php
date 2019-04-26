<?php

namespace Joselfonseca\LaravelApiTools\Tests\Traits;

use Illuminate\Database\Eloquent\Model;
use Joselfonseca\LaravelApiTools\Tests\TestCase;
use Joselfonseca\LaravelApiTools\Tests\Fakes\ModelFake;

class UuidScopeTraitTest extends TestCase
{
    /**
     * Run migrations for the tests
     */
    public function setUp() : void
    {
        parent::setUp();
        $this->artisan('migrate', ['--database' => 'testbench']);
    }

    /**
     * @test
     */
    public function it_adds_uuid_scope_to_model()
    {
        $model = new ModelFake([
            'name' => 'Jose Fonseca'
        ]);
        $model->save();
        $this->assertTrue(method_exists($model, 'scopeByUuid'));
        $this->assertNotNull($model->uuid);
        $this->assertInstanceOf(Model::class, ModelFake::byUuid($model->uuid)->first());
    }

}