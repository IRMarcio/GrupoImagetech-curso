<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class SalvarCursoRequest extends Request
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
        $registro = $this->route('curso');
        $id = $registro ? $registro->id : null;

        return [
            'codigo' => [
                'required',
                Rule::unique('cursos')->ignore($id),
            ],
            'nome' => ['required'],
            'valor_mensalidade' => ['required'],
            'valor_matricula' => ['required'],
            'duracao' => ['required'],
            'ativo' => ['required'],
            'tipo_periodo_id' => ['required']
        ];
    }
}
