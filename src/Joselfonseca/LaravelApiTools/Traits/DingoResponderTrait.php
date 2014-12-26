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
        if ($model instanceof \Eloquent) {
            return $this->RespondEloquentCollection($model, $transformer);
        }
        return $this->RespondDbArrayCollection($model, $transformer);
    }

    // ----------------------------------------------------------------------

    public function ResponseWithItem($idSlug, $model, $transformer) {
        if (is_numeric($idSlug)) {
            $model = $model->where('id',$idSlug);
        } elseif (is_string($idSlug)) {
            $model = $model->where('slug', '=', $idSlug);
        }
        $model = $model->first();
        if (empty($model)) {
            return $this->errorNotFound();
        }
        if($model instanceof \Eloquent){
            return $this->RespondEloquentItem($model, $transformer);
        }
        return $this->RespondDbItem($model, $transformer);
    }

    // ----------------------------------------------------------------------

    protected function parseSearchParams($model) {
        $modelReturn = $model;
        if (\Input::has($this->searchParam)) {
            $search = \Input::get($this->searchParam);
            $searchExplode = explode($this->searchFirstDelimiter, $search);
            foreach ($searchExplode as $searchExplodeItem) {
                $modelReturn = $this->parseParam($searchExplodeItem, $modelReturn);
            }
        }
        return $modelReturn;
    }

    // ----------------------------------------------------------------------

    protected function parseParam($searchExplodeItem, $modelReturn) {
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
    
    // ----------------------------------------------------------------------

    protected function RespondEloquentCollection($model, $transformer) {
        $model = $model->get();
        if ($model->isEmpty()) {
            return $this->response->noContent();
        }
        return $this->response->collection($model, $transformer);
    }
    
    // ----------------------------------------------------------------------
    
    protected function RespondDbArrayCollection($model, $transformer){
        if ($model->count() === 0) {
            return $this->response->noContent();
        }
        $collection = new \League\Fractal\Resource\Collection($model->get(), $transformer);
        $manager = new \League\Fractal\Manager;
        return $this->response->array($manager->createData($collection)->toArray());
    }
    
    // ----------------------------------------------------------------------
    
    protected function RespondEloquentItem($model, $transformer){
        return $this->response->item($model, $transformer);
    }
    
    // ----------------------------------------------------------------------
    
    protected function RespondDbItem($model, $transformer){
        $item = new \League\Fractal\Resource\Item($model, $transformer);
        $manager = new \League\Fractal\Manager;
        return $this->response->array($manager->createData($item)->toArray());
    }

}
