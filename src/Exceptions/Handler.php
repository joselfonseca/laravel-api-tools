<?php

namespace Joselfonseca\LaravelApiTools\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Joselfonseca\LaravelApiTools\Traits\ResponseBuilder;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends \App\Exceptions\Handler
{

    use ResponseBuilder;

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($request->is(config('api.prefix', 'api').'/*')){

            if ($exception instanceof ValidationException) {
                return $this->validationError($exception->getMessageBag());
            }
            if($exception instanceof HttpException) {
                $body = [
                    'code' => $exception->getStatusCode(),
                    'title' => $exception->getMessage()
                ];
                return response($body)->setStatusCode($exception->getStatusCode());
            }
            if($exception instanceof AuthenticationException) {
                $body = [
                    'code' => 401,
                    'title' => $exception->getMessage()
                ];
                return response($body)->setStatusCode(401);
            }
            if($exception instanceof ModelNotFoundException){
                return $this->errorNotFound();
            }
            if($exception instanceof UnTransformableResourceException) {
                return $this->errorInternal('The entity is not transformable, check that the transformer is present and the resource being passed is a Model, Collection or Paginator');
            }

        }
        return parent::render($request, $exception);
    }

}