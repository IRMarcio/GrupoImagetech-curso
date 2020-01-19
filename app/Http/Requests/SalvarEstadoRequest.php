<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class SalvarEstadoRequest extends Request
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
        $registro = $this->route('estado');
        $id = $registro ? $registro->id : null;

        return [
            'descricao' => [
                'required',
                Rule::unique('uf')->ignore($id),
            ],
            'uf'        => [
                'required',
                Rule::unique('uf')->ignore($id),
            ]
        ];
    }
}
