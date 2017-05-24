<?php

namespace Joselfonseca\LaravelApiTools\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FilterableTrait
 * @package Joselfonseca\LaravelApiTools\Traits
 * @author Juan Almedia https://github.com/juanelojga
 */
trait FilterableTrait
{
    /**
     * Filters to be applied
     * @var array
     */
    protected $_filters = [];

    /**
     * Valid query operators
     * @var array
     */
    protected $_validOperators = [
        'exact' => '=',
        'partial' => 'like',
        'start' => 'like',
        'end' => 'like',
        'condition' => null,
    ];

    /**
     * Valid query statements
     * @var array
     */
    protected $_validStatements = [
        'and',
        'or',
        'date',
        'ordate',
        'has',
    ];

    /**
     * Get filterable fields, must be defined
     * @return array
     */
    public abstract function getFilterableFields();

    /**
     * Get filters to be applied
     * @return array
     */
    public function getFilters()
    {
        return $this->_filters;
    }

    /**
     * Add a filter to filter array
     * @param array $request
     */
    public function addFilter($request = [])
    {
        $rules = $this->getFilterableFields();

        foreach ($request as $field => $value) {
            if (array_key_exists($field, $rules) && $value) {
                $this->_filters[$field] = $rules[$field];
            }
        }
    }

    /**
     * Apply filters to model
     * @param  Model $model
     * @param  array $request
     * @return Model
     */
    public function applyFilters($model, $request)
    {
        $filters = $this->getFilters();

        foreach ($filters as $field => $rule) {
            list($operator, $statement, $condition) = $this->parseRule($rule);

            if (env('DB_CONNECTION') == 'pgsql' && $condition == 'like') {
                $condition = 'ilike';
            }

            switch ($operator) {
                case 'start':
                    $value = $request[$field] . '%';
                    break;

                case 'end':
                    $value = '%' . $request[$field];
                    break;

                case 'partial':
                    $value = '%' . $request[$field] . '%';
                    break;

                case 'operator':
                    $value = $request[$field];
                    break;

                default:
                    $value = $request[$field];
                    break;
            }

            switch ($statement) {
                case 'or':
                    $model->orWhere($field, $condition, $value);
                    break;

                case 'date':
                    $model->whereDate($field, $condition, $value);
                    break;

                case 'ordate':
                    $model->orWhereDate($field, $condition, $value);
                    break;

                case 'has':
                    $model->has($field, $condition, $value);
                    break;

                default:
                    $model->where($field, $condition, $value);
                    break;
            }
        }

        return $model;
    }

    /**
     * Process rules to filter fields
     * @param  string $compoundRule
     * @return array
     */
    public function parseRule($compoundRule = '')
    {
        $operator = 'exact';
        $statement = 'and';
        $condition = '=';

        foreach (explode('|', $compoundRule) as $singleRule) {

            $arrayRule = explode(':', $singleRule);
            $rule = $arrayRule[0];

            if (array_key_exists($rule, $this->_validOperators)) {
                $operator = $rule != 'condition' ? $rule : 'custom';
                $condition = $rule != 'condition' ? $this->_validOperators[$rule] : $arrayRule[1];
            } else {
                if (in_array($rule, $this->_validStatements)) {
                    $statement = $rule;
                }
            }

        }

        return [$operator, $statement, $condition];
    }
}
