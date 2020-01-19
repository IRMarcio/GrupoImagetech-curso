<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class SalvarCatmatRequest extends Request
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
        $registro = $this->route('catmat');
        $id = $registro ? $registro->id : null;

        return [
            'codigo' => [
                'required',
                Rule::unique('catmat')->ignore($id),
            ],
            'unidade_fornecimento' => ['required']
        ];
    }
}
