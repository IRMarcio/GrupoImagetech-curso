<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class SalvarCentroDistribuicaoRequest extends Request
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
        $registro = $this->route('centro_distribuicao');
        $id = $registro ? $registro->id : null;

        return [
            'descricao'                        => [
                'required',
                Rule::unique('centro_distribuicao')->ignore($id)->whereNotNull('created_at')
            ],
            'responsavel'                        => ['required'],
        ];
    }
}
