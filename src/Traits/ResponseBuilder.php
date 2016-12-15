<?php

namespace Joselfonseca\LaravelApiTools\Traits;

use Illuminate\Contracts\Support\MessageBag;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ResponseBuilder
 * @package Joselfonseca\LaravelApiTools\Traits
 */
trait ResponseBuilder
{

    /**
     * @param String|null $location
     * @param String|null $content
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function created($location = null, $content = null)
    {
        $response = response($content);
        $response->setStatusCode(201);
        if(! is_null($location)){
            $response->header('Location', $location);
        }
        return $response;
    }

    /**
     * @param String|null $location
     * @param String|null $content
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function accepted($location = null, $content = null)
    {
        $response = response($content);
        $response->setStatusCode(202);
        if (! is_null($location)) {
            $response->header('Location', $location);
        }
        return $response;
    }

    /**
     * @param MessageBag $bag
     * @param string $errorMessage
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function validationError(MessageBag $bag, $errorMessage = "Validation Error")
    {
        $response = response([
            'message' => $errorMessage,
            'errors' => $bag->toArray(),
            'code' => 422
        ]);
        return $response->setStatusCode(422);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function noContent()
    {
        $response = response(null);
        return $response->setStatusCode(204);
    }

    /**
     * @param String $message
     * @param int $statusCode
     */
    public function error($message, $statusCode)
    {
        throw new HttpException($statusCode, $message);
    }

    /**
     * @param string $message
     */
    public function errorNotFound($message = 'Not Found')
    {
        $this->error($message, 404);
    }

    /**
     * @param string $message
     */
    public function errorBadRequest($message = 'Bad Request')
    {
        $this->error($message, 400);
    }

    /**
     * @param string $message
     */
    public function errorForbidden($message = 'Forbidden')
    {
        $this->error($message, 403);
    }

    /**
     * @param string $message
     */
    public function errorInternal($message = 'Internal Error')
    {
        $this->error($message, 500);
    }

    /**
     * @param string $message
     */
    public function errorUnauthorized($message = 'Unauthorized')
    {
        $this->error($message, 401);
    }

    /**
     * @param string $message
     */
    public function errorMethodNotAllowed($message = 'Method Not Allowed')
    {
        $this->error($message, 405);
    }

}