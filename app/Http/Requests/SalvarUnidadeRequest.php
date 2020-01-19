<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Services\Mascarado;
use Illuminate\Validation\Rule;

class SalvarUnidadeRequest extends Request
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
        $registro = $this->route('unidade');
        $id = $registro ? $registro->id : null;

        return [
            'descricao'                        => [
                'required',
                Rule::unique('unidade')->ignore($id)->whereNotNull('created_at')
            ],
            'responsavel'                        => ['required'],
        ];
    }
}
