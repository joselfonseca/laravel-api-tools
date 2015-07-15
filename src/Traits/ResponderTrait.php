<?php

namespace Joselfonseca\LaravelApiTools\Traits;

use Dingo\Api\Routing\Helpers;

trait ResponderTrait
{

    use Helpers;

    public function responseWithPaginator($limit, $model, $transformer)
    {
        return $this->response->paginator($model->paginate($limit), $transformer);
    }

    public function responseWithItem($model, $transformer) {
        return $this->response->item($model, $transformer);
    }

    public function responseWithCollection($model, $transformer) {
        return $this->response->collection($model->get(), $transformer);
    }

    public function responseNoContent()
    {
        return $this->response->noContent();
    }

    public function errorUnauthorized($message = null)
    {
        return $this->response->errorForbidden($message);
    }

    public function errorInternal($message = null)
    {
        return $this->response->errorInternal($message);
    }

    public function simpleArray(array $array = [])
    {
        return $this->response->array($array);
    }

    public function respondCreated($location = null)
    {
        return $this->response->created($location);
    }
}