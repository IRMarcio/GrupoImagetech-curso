<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class SalvarPerfilRequest extends Request
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
        $registro = $this->route('perfil');
        $id = isset($registro->id) ? $registro->id : $registro;

        $unidade = $this->request->get('unidade_id');

        return [
            'nome'          => [
                'required',
                Rule::unique('perfil')->ignore($id)->where(function ($query) use ($unidade) {
                    $query->where('unidade_id', $unidade);
                }),
            ],
            'unidade_id' => ['required', 'integer', 'exists:unidade,id']
        ];
    }
}
