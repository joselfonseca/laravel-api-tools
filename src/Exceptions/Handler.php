<?php

namespace Joselfonseca\LaravelApiTools\Exceptions;

use Exception;
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
        if($request->is('api/*')){

            if ($exception instanceof ValidationException) {
                return $this->validationError($exception->gerMessageBag());
            }
            if($exception instanceof HttpException) {
                $body = [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getStatusCode()
                ];
                return response($body)->setStatusCode($exception->getStatusCode());
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