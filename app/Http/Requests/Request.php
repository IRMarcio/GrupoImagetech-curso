<?php

namespace App\Http\Requests;

use App\Exceptions\AuthorizationException;
use App\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException(collect($validator->errors()->all()));
    }

    /**
     * Get the response for a forbidden operation.
     *
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException();
    }
}
