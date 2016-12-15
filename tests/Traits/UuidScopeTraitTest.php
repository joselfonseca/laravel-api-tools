<?php

namespace Joselfonseca\LaravelApiTools\Tests\Traits;

use Illuminate\Database\Eloquent\Model;
use Joselfonseca\LaravelApiTools\Tests\Stubs\ModelStub;
use Joselfonseca\LaravelApiTools\Tests\TestCase;

class UuidScopeTraitTest extends TestCase
{
    /**
     * Run migrations for the tests
     */
    public function setUp()
    {
        parent::setUp();
        $this->loadMigrationsFrom([
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../migrations'),
        ]);
    }

    /**
     * @test
     */
    public function it_adds_uuid_scope_to_model()
    {
        $model = new ModelStub([
            'name' => 'Jose Fonseca',
            'uuid' => '6e44642b-aa42-4392-b917-34c03ea846e7'
        ]);
        $model->save();
        $this->assertTrue(method_exists($model, 'scopeByUuid'));
        $this->assertInstanceOf(Model::class, ModelStub::byUuid('6e44642b-aa42-4392-b917-34c03ea846e7')->first());
    }

}