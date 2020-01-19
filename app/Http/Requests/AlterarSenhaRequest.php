<?php

namespace App\Http\Requests;

class AlterarSenhaRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'senha'                   => 'required',
            'nova_senha'              => 'required|confirmed',
            'nova_senha_confirmation' => 'required',
        ];
    }
}
