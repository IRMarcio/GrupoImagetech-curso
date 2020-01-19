<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Services\Mascarado;
use Illuminate\Validation\Rule;

class SalvarTransportadoraRequest extends Request
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
        $registro = $this->route('empresa');
        $id = $registro ? $registro->id : null;

        return [
            'nome_fantasia'                        => [
                'required',
                Rule::unique('empresa')->ignore($id)->whereNotNull('created_at')
            ],
            'razao_social'                        => [
                'required',
                Rule::unique('empresa')->ignore($id)->whereNotNull('created_at')
            ],
            'cnpj'                        => [
                'required',
                Rule::unique('empresa')->ignore($id)->whereNotNull('created_at')
            ],
            'contato'                        => ['required'],
        ];
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function validationData()
    {
        $dados = parent::validationData();
        $dados['cnpj'] = Mascarado::removerMascara($dados['cnpj']);

        return $dados;
    }
}
