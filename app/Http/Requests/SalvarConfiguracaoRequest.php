<?php

namespace App\Http\Requests;

class SalvarConfiguracaoRequest extends Request
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
        return [
            'max_tentativas_login'      => 'required|numeric|min:1|max:10',
            // 'tempo_maximo_sessao'       => 'required|numeric|min:1',
            // 'acao_apos_timeout_sessao'  => 'required|in:B,L',
            'dias_max_alterar_senha'    => 'required|numeric|min:1|max:180', // 6 meses
        ];
    }
}
