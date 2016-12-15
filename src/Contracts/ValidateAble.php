<?php

namespace Joselfonseca\LaravelApiTools\Contracts;

use Joselfonseca\LaravelApiTools\Exceptions\ValidationException;

/**
 * Interface ValidateAble
 * @package App\Contracts
 */
interface ValidateAble
{

    /**
     * Runs the validator and throws exception if fails
     * @param array $attributes
     * @param $rules
     * @param $messages
     * @throws ValidationException
     */
    public function runValidator(array $attributes, $rules, $messages);
}
