<?php

namespace Joselfonseca\LaravelApiTools\Traits;

use Joselfonseca\LaravelApiTools\Exceptions\InvalidArgumentException;

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
    protected $whereTypeDefault = 'AND';

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
                $modelReturn = $this->_parseParam($searchExplodeItem, $modelReturn);
            }
        }

        return $modelReturn;
    }
    
    // ----------------------------------------------------------------------

    protected function _parseParam($searchExplodeItem, $modelReturn) {
        preg_match_all('/([\w]+)\(([^\)]+)\)/', $searchExplodeItem, $allModifiersArr);
        $column = $allModifiersArr[1][0];
        $valueCond = explode($this->searchSecondDelimiter, $allModifiersArr[2][0], 3);
        if (empty($valueCond)) {
            throw new InvalidArgumentException;
        }
        $value = $valueCond[0];
        $condition = $this->searchDefaultCondition;
        $type = $this->whereTypeDefault;
        if (!empty($valueCond[1])) {
            $condition = $valueCond[1];
        }
        if (!empty($valueCond[2])) {
            $type = strtoupper($valueCond[2]);
        }
        if ($type === "AND") {
            return $modelReturn->where($column, $condition, $value);
        }
        return $modelReturn->orWhere($column, $condition, $value);
    }

}
