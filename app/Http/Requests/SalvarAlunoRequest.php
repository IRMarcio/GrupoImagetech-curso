<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Services\Mascarado;
use Illuminate\Validation\Rule;

class SalvarAlunoRequest extends Request
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
        $registro = $this->route('aluno');
        $id = $registro ? $registro->id : null;

        return [
            'nome'  => ['required'],
            'cpf'   => [
                'required',
                Rule::unique('alunos')->ignore($id)->whereNotNull('created_at')
            ],
            'email' => ['required'],
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
        $dados['cpf'] = Mascarado::removerMascara($dados['cpf']);

        return $dados;
    }
}
