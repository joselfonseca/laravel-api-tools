<?php

namespace Joselfonseca\LaravelApiTools\Tests\Traits;

use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;
use Joselfonseca\LaravelApiTools\Tests\TestCase;
use Joselfonseca\LaravelApiTools\Traits\ResponseBuilder;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ResponseBuilderTest extends TestCase
{

    use ResponseBuilder;

    /**
     * @test
     */
    public function it_returns_response_from_validation()
    {
        $response = $this->validationError(new MessageBag(['name' => 'the name is required']));
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(422, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_returns_response_created()
    {
        $response = $this->created();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_returns_response_accepted()
    {
        $response = $this->accepted();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(202, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_returns_response_noContent()
    {
        $response = $this->noContent();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_throws_error_exception()
    {
        try{
            $this->error('some message', 500);
            $this->fail('No exception thrown');
        }catch (HttpException $e){
            $this->assertEquals(500, $e->getStatusCode());
        }
    }

    /**
     * @test
     */
    public function it_throws_error_exception_error_not_found()
    {
        try{
            $this->errorNotFound();
            $this->fail('No exception thrown');
        }catch (HttpException $e){
            $this->assertEquals(404, $e->getStatusCode());
        }
    }

    /**
     * @test
     */
    public function it_throws_error_exception_bad_request()
    {
        try{
            $this->errorBadRequest();
            $this->fail('No exception thrown');
        }catch (HttpException $e){
            $this->assertEquals(400, $e->getStatusCode());
        }
    }

    /**
     * @test
     */
    public function it_throws_error_exception_error_forbidden()
    {
        try{
            $this->errorForbidden();
            $this->fail('No exception thrown');
        }catch (HttpException $e){
            $this->assertEquals(403, $e->getStatusCode());
        }
    }

    /**
     * @test
     */
    public function it_throws_error_exception_error_internal()
    {
        try{
            $this->errorInternal();
            $this->fail('No exception thrown');
        }catch (HttpException $e){
            $this->assertEquals(500, $e->getStatusCode());
        }
    }

    /**
     * @test
     */
    public function it_throws_error_exception_error_method_not_allowed()
    {
        try{
            $this->errorMethodNotAllowed();
            $this->fail('No exception thrown');
        }catch (HttpException $e){
            $this->assertEquals(405, $e->getStatusCode());
        }
    }

}