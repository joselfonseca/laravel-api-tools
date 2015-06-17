<?php

namespace Joselfonseca\LaravelApiTools\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as IlluminateHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Joselfonseca\LaravelApiTools\ApiToolsResponder;
use Exception;
use Joselfonseca\LaravelApiTools\Exceptions\ValidationException;
use Joselfonseca\LaravelApiTools\Exceptions\AuthorizationException;
use Joselfonseca\LaravelApiTools\Exceptions\AclException;
use Joselfonseca\LaravelApiTools\Exceptions\StoreResourceFailedException;

/**
 * Description of Handler
 *
 * @author josefonseca
 */
class Handler extends IlluminateHandler
{

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if($e instanceof ModelNotFoundException){
            return ApiToolsResponder::resourceNotFound();
        }
        if($e instanceof ValidationException){
            return ApiToolsResponder::validationError($e->validator);
        }
        if($e instanceof AuthorizationException){
            return ApiToolsResponder::unauthorizedAccess($e->getMessage());
        }
        if($e instanceof AclException){
            return ApiToolsResponder::unauthorizedAccess("ACL Exception - not enough permissions", 'ACLException');
        }
        if($e instanceof StoreResourceFailedException){
            return ApiToolsResponder::simpleJson(['exception' => 'StoreResourceException', 'errors' => $e->getErrors()], 400);
        }
        return parent::render($request, $e);
    }
}