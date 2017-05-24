<?php

namespace Joselfonseca\LaravelApiTools\Traits;

/**
 * Class OrderQueryResultHelper
 * @package Joselfonseca\LaravelApiTools\Traits
 * @author Juan Almedia https://github.com/juanelojga
 */
trait OrderQueryResultHelper
{
    /**
     * Valid directions
     * @var array
     */
    protected $_validOrderByDirections = [
        'asc',
        'desc',
    ];

    /**
     * @var array
     */
    protected $_orderingRules = [];

    /**
     * Get column and direction from request
     * @param  string $rule
     * @return array
     */
    protected function _getColumnAndDirection($rule = '')
    {
        try {
            if (!$rule) {
                throw new \Exception("orderBy column empty", 1);
            }

            if (strpos($rule, ':') === false) {
                $column = $rule;
                $direction = 'asc';
            } else {
                $ruleWithArgument = explode(':', $rule);

                if (!$ruleWithArgument[0]) {
                    throw new \Exception("orderBy column empty", 1);
                }

                $column = $ruleWithArgument[0];

                if (in_array($ruleWithArgument[1], $this->_validOrderByDirections)) {
                    $direction = $ruleWithArgument[1];
                } else {
                    $direction = 'asc';
                }
            }

        } catch (\Exception $e) {
            return [];
        }

        return [
            $column => $direction
        ];
    }

    /**
     * Return ordering rules
     * @return array 
     */
    public function getOrderingRules()
    {
        return $this->_orderingRules;
    }

    /**
     * Get ordering rules from array
     * @param  array  $request
     * @return array
     */
    public function processOrderingRules($request = [])
    {
        try {

            if (is_array($request) && count($request) > 0) {
                if (isset($request['orderBy'])) {
                    $orderBy = $request['orderBy'];

                    if (!$orderBy) {
                        throw new \Exception("orderBy field empty", 1);
                    }

                    if (strpos($orderBy, ',') === false) {
                        $this->_orderingRules = array_merge($this->_orderingRules, $this->_getColumnAndDirection($orderBy));
                    } else {
                        $orderByMultipleRules = explode(',', $orderBy);
                        foreach ($orderByMultipleRules as $orderBySingleRule) {
                            $this->_orderingRules = array_merge($this->_orderingRules, $this->_getColumnAndDirection($orderBySingleRule));
                        }
                    }
                } else {
                    throw new \Exception("orderBy field not defined", 1);
                }

            } else {
                throw new \Exception("Empty Request", 1);
            }

        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Apply order rules in model
     * @param  object $model
     * @param  array $orderingRules
     * @return object
     */
    public function applyOrderingRules($model)
    {
        $orderingRules = $this->getOrderingRules();

        foreach ($orderingRules as $column => $direction) {
            $model->orderBy($column, $direction);
        }

        return $model;
    }
}