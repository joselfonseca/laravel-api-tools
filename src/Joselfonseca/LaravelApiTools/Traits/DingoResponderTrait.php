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
        
        $model = $this->BuildFilter($model);

        $limit = \Input::get('limit', 0);

        if (empty($limit)) {
            return $this->ResponseWithCollection($model, $transformer);
        }

        return $this->response->paginator($model->paginate($limit), $transformer);
    }

    // ----------------------------------------------------------------------

    public function ResponseWithCollection($model, $transformer) {
        
        $model = $model->get();
        

        if($model->isEmpty()){
         
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
    
    public function BuildFilter($model){
        
        $search = \Input::get('search', 0);
        /** if no filter then nothing to do **/
        if(empty($search)){
            return $model;
        }
        
        $groups = explode(',', $search);
        
        foreach($groups as $group){
            $group = trim($group);
            preg_match_all('/([\w]+)\(([^\)]+)\)/', $group, $modifier);
            $column = $modifier[1][0];
            list($condition, $value) = explode('|', $modifier[2][0]);
            $model = $model->where($column,$condition,$value);
        }
        
        return $model;
    }
}
