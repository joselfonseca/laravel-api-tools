<?php

namespace Joselfonseca\LaravelApiTools\Traits;

use Dingo\Api\Routing\Helpers;

/**
 * Trait ResponderTrait
 * @package Joselfonseca\LaravelApiTools\Traits
 */
trait ResponderTrait
{

    use Helpers;

    /**
     * @param $limit
     * @param $model
     * @param $transformer
     * @param null $urlPath
     * @param array $append
     * @return mixed
     */
    public function responseWithPaginator($limit, $model, $transformer, $urlPath = null, array $append = null, array $parameters = [], Closure $after = null)
    {
        $paginator = $model->paginate($limit);
        if(!empty($urlPath)){
            $paginator->setPath($urlPath);
        }
        if(!empty($append) && is_array($append)){
            $paginator->appends($append);
        }
        return $this->response->paginator($paginator, $transformer, $parameters, $after);
    }

    /**
     * @param $model
     * @param $transformer
     * @return mixed
     */
    public function responseWithItem($model, $transformer, array $parameters = [], Closure $after = null) {
        return $this->response->item($model, $transformer, $parameters, $after);
    }

    /**
     * @param $model
     * @param $transformer
     * @return mixed
     */
    public function responseWithCollection($model, $transformer, array $parameters = [], Closure $after = null) {
        return $this->response->collection($model->get(), $transformer,  $parameters, $after);
    }

    /**
     * @return mixed
     */
    public function responseNoContent()
    {
        return $this->response->noContent();
    }

    /**
     * @param null $message
     * @return mixed
     */
    public function errorUnauthorized($message = null)
    {
        return $this->response->errorForbidden($message);
    }

    /**
     * @param null $message
     * @return mixed
     */
    public function errorInternal($message = null)
    {
        return $this->response->errorInternal($message);
    }

    /**
     * @param array $array
     * @return mixed
     */
    public function simpleArray(array $array = [])
    {
        return $this->response->array($array);
    }

    /**
     * @param null $location
     * @return mixed
     */
    public function respondCreated($location = null)
    {
        return $this->response->created($location);
    }
}