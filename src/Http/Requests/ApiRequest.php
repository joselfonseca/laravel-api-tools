<?php

namespace Joselfonseca\LaravelApiTools\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Dingo\Api\Exception\StoreResourceFailedException;

/**
 * Description of ApiRequest
 *
 * @author josefonseca
 */
class ApiRequest extends FormRequest
{

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return mixed
     */
    protected function failedValidation(Validator $validator)
    {
        throw new StoreResourceFailedException('Validation Error',$this->formatErrors($validator));
    }

}