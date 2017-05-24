<?php

namespace Joselfonseca\LaravelApiTools\Traits;

/**
 * Class ProcessMultipleParameterHelper
 * @package Joselfonseca\LaravelApiTools\Traits
 * @author Juan Almedia https://github.com/juanelojga
 */
trait ProcessMultipleParameterHelper
{
    /**
     * @param array $result
     * @param string $parameter
     * @return array
     */
    protected function _addParameter($result = [], $parameter = '') {
		if ($parameter && $parameter !== ',') {
			array_push($result, $parameter);
		}

		return $result;
	}

    /**
     * @param string $parameter
     * @return array
     */
    public function processParameter($parameter = '')
	{
		$result = [];

		if (strpos($parameter, ',')) {
			$parameters = explode(',', $parameter);
			foreach ($parameters as $singleParameter) {
				$result = $this->_addParameter($result, $singleParameter);
			}
		} else {
			$result = $this->_addParameter($result, $parameter);
		}

		return $result;
	}
}