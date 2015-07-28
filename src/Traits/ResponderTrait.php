<?php

namespace Joselfonseca\LaravelApiTools\Traits;

use Dingo\Api\Routing\Helpers;

trait ResponderTrait
{

    use Helpers;

    public function responseWithPaginator($limit, $model, $transformer, $urlPath = null, array $append = null)
    {
        $paginator = $model->paginate($limit);
        if(!empty($urlPath)){
            $paginator->setPath($urlPath);
        }
        if(!empty($append) && is_array($append)){
            $paginator->appends($append);
        }
        return $this->response->paginator($paginator, $transformer);
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