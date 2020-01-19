<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class SalvarEnderecamentoRequest extends Request
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
        $registro = $this->route('enderecamento');
        $id = $registro ? $registro->id : null;

        return [
            'area' => ['required'],
            'rua' => ['required'],
            'modulo' => ['required'],
            'nivel' => ['required'],
            'vao' => ['required'],
            'secao_id' => ['required'],
            'tipo_produto_id' => ['required']
        ];
    }
}
