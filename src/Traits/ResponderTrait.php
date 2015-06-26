<?php

namespace Joselfonseca\LaravelApiTools\Traits;

use Joselfonseca\LaravelApiTools\ApiToolsResponder;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

trait ResponderTrait
{

    public function responseWithPaginator($limit, $model, $transformer,
                                          array $includes = [],
                                          array $extra = [])
    {
        $paginator = $model->paginate($limit);
        $resource  = new Collection($paginator->getCollection(), $transformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        return ApiToolsResponder::fractal($resource, $includes, $extra);
    }

    public function responseWithitem($id, $model, $transformer,
                                     array $includes = [], array $extra = [])
    {
        if (!is_null($id)) {
            $model = $model->findOrFail($id);
        }
        $item = new Item($model, $transformer);
        return ApiToolsResponder::fractal($item, $includes, $extra);
    }

    public function responseWithCollection($model, $transformer,
                                           array $includes = [],
                                           array $extra = [])
    {
        $collection = new Collection($model->get(), $transformer);
        return ApiToolsResponder::fractal($collection, $includes, $extra);
    }

    public function responseNoContent()
    {
        return ApiToolsResponder::responseNoContent();
    }

    public function errorUnauthorized($message = null)
    {
        if (empty($message)) {
            $message = "You dont have permissions for this resource";
        }
        return ApiToolsResponder::unauthorizedAccess($message);
    }

    public function errorInternal($errorCode = null, $message = null)
    {
        if (!empty($message)) {
            $message = "You dont have permissions for this resource";
        }
        if (!empty($errorCode)) {
            $errorCode = "Exception";
        }
        return ApiToolsResponder::appError($errorCode, $message);
    }

    public function simpleArray(array $array = [])
    {
        return ApiToolsResponder::simpleJson($array);
    }

    public function respondCreated()
    {
        return ApiToolsResponder::created();
    }
}