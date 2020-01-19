<?php

namespace App\Http\Requests;

use App\Services\Mascarado;
use Illuminate\Validation\Rule;
use App\Models\Usuario;

class SalvarUsuarioRequest extends Request
{

    protected $id = null;

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
        if (is_null($this->id)) {
            $registro = $this->route('usuario');
            $this->id = isset($registro->id) ? $registro->id : $registro;

            if ($this->usuario_id) {
                $registro = Usuario::findBySlugOrFail($this->usuario_id);
                $this->id = isset($registro->id) ? $registro->id : $registro;
            }
        }

        return [
            'nome'                    => 'required|max:200',
            'cpf'                     => [
                'max:11',
                Rule::unique('usuario')->ignore($this->id)->whereNotNull('created_at')
            ],
            'email'           => 'max:150',
            'tel_celular'     => 'max:100',
            'tel_residencial' => 'max:100',
            'super_admin'     => 'boolean',
            'gestor'          => 'boolean',
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
