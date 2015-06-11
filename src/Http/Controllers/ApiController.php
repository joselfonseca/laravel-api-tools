<?php

namespace Joselfonseca\LaravelApiTools\Http\Controllers;

use Joselfonseca\LaravelAdmin\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

/**
 * Description of ApiController
 *
 * @author josefonseca
 */
class ApiController extends Controller
{

    use Helpers;

    public function responseWithPaginator($limit, $model, $transformer)
    {
        return $this->response->paginator($model->paginate($limit), $transformer);
    }

    public function responseWithitem($model, $transformer)
    {
        return $this->response->item($model, $transformer);
    }

    public function responseWithCollection($model, $transformer)
    {
        return $this->response->collection($model->all(), $transformer);
    }

    public function responseNoContent()
    {
        return $this->response->noContent();
    }
}