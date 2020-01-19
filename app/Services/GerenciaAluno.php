<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Models\Aluno;
use App\Models\Estado;
use App\Models\Municipio;

class GerenciaAluno
{

    /**
     * Carrega as dependências para cadastro/alteração de empresa
     *
     * @param  Aluno  $aluno
     *
     * @return array
     */
    public function carregarDependencias(Aluno $aluno = null)
    {
        $estados = Estado::orderBy('uf', 'ASC')->get();
        $municipios = null;


        if (!is_null($aluno) && !is_null($aluno->endereco)  && $aluno->endereco->municipio_id) {
            $municipios = Municipio::where('uf_id', $aluno->endereco->uf_id)->get();
        }


        return compact('estados', 'municipios');
    }

    /**
     * Criar empresa
     *
     * @param  array  $dados
     *
     * @return \App\Models\Aluno
     * @throws ValidationException
     */
    public function criar($aluno, $dados)
    {
        $aluno->transformarPermanente($dados);
        $aluno->endereco()->create($dados);

        return $aluno;
    }

    /**
     * Alterar empresa
     *
     * @param  int  $id
     * @param  array  $dados
     *
     * @return \App\Models\Aluno
     * @throws ValidationException
     */
    public function alterar($id, $dados)
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->update($dados);

        return $aluno;
    }

    /**
     * Exclui uma empresa.
     *
     * @param  int  $id
     *
     * @return bool|null
     */
    public function excluir($id)
    {
        return Aluno::find($id)->delete();
    }
}
