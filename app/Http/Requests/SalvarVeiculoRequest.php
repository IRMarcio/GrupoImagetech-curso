<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class SalvarVeiculoRequest extends Request
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
        $registro = $this->route('veiculo');
        $id = $registro ? $registro->id : null;

        return [
            'placa' => [
                'required',
                Rule::unique('veiculo')->ignore($id),
            ],
            'renavam'        => [
                'required',
                Rule::unique('veiculo')->ignore($id),
            ],
            'municipio_id_licenciamento' => [
                'required'
            ]
        ];
    }
}
