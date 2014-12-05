<?php

namespace Joselfonseca\LaravelApiTools\Traits;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;

/**
 * Responses for DingoApi
 * @author Rigo B Castro
 * @author Jose Fonseca <jose@ditecnologia.com>
 */
trait DingoResponderTrait {

    // ----------------------------------------------------------------------

    public function ResponseWithPaginator($model, $transformer) {

        $limit = \Input::get('limit', 0);

        if (empty($limit)) {
            return $this->ResponseWithCollection($model, $transformer);
        }

        return $this->response->paginator($model->paginate($limit), $transformer);
    }

    // ----------------------------------------------------------------------

    public function ResponseWithCollection($model, $transformer) {
        
        $model = $model->get();

        $model->isEmpty() && $this->setStatusCode(204);

        return $this->response->collection($model, $transformer);
    }

    // ----------------------------------------------------------------------

    public function ResponseWithItem($idSlug, $model, $transformer) {
        
        if (is_numeric($idSlug)) {
            $model = $model->find($idSlug);
        } elseif (is_string($idSlug)) {
            $model = $model->where('slug', '=', $idSlug)->firstOrFail();
        }

        if (empty($model)) {
            return $this->errorNotFound();
        }

        return $this->response->item($model, $transformer);
    }

    // ----------------------------------------------------------------------
}
