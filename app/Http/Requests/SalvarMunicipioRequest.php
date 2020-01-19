<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class SalvarMunicipioRequest extends Request
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
        $registro = $this->route('municipio');
        $id = $registro ? $registro->id : null;

        $ufId = $this->request->get('uf_id');

        return [
            'descricao' => [
                'required',
                Rule::unique('municipio')->ignore($id)->where(function ($query) use ($ufId) {
                    $query->where('uf_id', $ufId);
                }),
            ],
            'cep'       => ['required_if:ind_cep_unico,1'],
            'uf_id' => ['required', 'integer', 'exists:uf,id']
        ];
    }
}
