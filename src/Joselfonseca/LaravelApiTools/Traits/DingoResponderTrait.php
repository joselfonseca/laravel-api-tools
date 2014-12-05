<?php

namespace Joselfonseca\LaravelApiTools\Traits;

/**
 * Responses for DingoApi
 * @author Rigo B Castro
 * @author Jose Fonseca <jose@ditecnologia.com>
 */
trait DingoResponderTrait {
    
    protected $searchParam = 'search';
    protected $searchFirstDelimiter = ':';
    protected $searchSecondDelimiter = '|';
    protected $searchDefaultCondition = '=';

    // ----------------------------------------------------------------------

    public function ResponseWithPaginator($model, $transformer) {

        $model = $this->parseSearchParams($model);

        $limit = \Input::get('limit', 0);

        if (empty($limit)) {
            return $this->ResponseWithCollection($model, $transformer);
        }

        return $this->response->paginator($model->paginate($limit), $transformer);
    }

    // ----------------------------------------------------------------------

    public function ResponseWithCollection($model, $transformer) {

        $model = $model->get();


        if ($model->isEmpty()) {

            return $this->response->noContent();
        }

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

    protected function parseSearchParams($model) {
        $modelReturn = $model;

        if (\Input::has($this->searchParam)) {
            $search = \Input::get($this->searchParam);

            $searchExplode = explode($this->searchFirstDelimiter, $search);

            foreach ($searchExplode as $searchExplodeItem) {
                preg_match_all('/([\w]+)\(([^\)]+)\)/', $searchExplodeItem, $allModifiersArr);

                $column = $allModifiersArr[1][0];
                $valueCond = explode($this->searchSecondDelimiter, $allModifiersArr[2][0], 2);

                if (!empty($valueCond)) {
                    $value = $valueCond[0];
                    $condition = $this->searchDefaultCondition;

                    if (!empty($valueCond[1])) {
                        $condition = $valueCond[1];
                    }

                    $modelReturn = $modelReturn->where($column, $condition, $value);
                }
            }
        }

        return $modelReturn;
    }

}
