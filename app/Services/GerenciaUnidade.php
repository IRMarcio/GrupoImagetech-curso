<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Unidade;

class GerenciaUnidade
{
    /**
     * Carrega as dependências para cadastro/alteração de unidade
     * 
     * @param Unidade $unidade
     * 
     * @return array
     */
    public function carregarDependencias(Unidade $unidade = null)
    {
        $estados = Estado::orderBy('uf', 'ASC')->get();
        $municipios = null;

        if (!is_null($unidade) && $unidade->municipio_id) {
            $municipios = Municipio::where('uf_id', $unidade->municipio->uf_id)->get();
        }

        return compact('estados', 'municipios');
    }

    /**
     * Criar unidade
     *
     * @param array $dados
     *
     * @return \App\Models\Unidade
     * @throws ValidationException
     */
    public function criar($unidade, $dados)
    {
        $unidade->transformarPermanente($dados);

        return $unidade;
    }

    /**
     * Alterar unidade
     *
     * @param int $id
     * @param array $dados
     *
     * @return \App\Models\Unidade
     * @throws ValidationException
     */
    public function alterar($id, $dados)
    {
        $unidade = Unidade::findOrFail($id);
        $unidade->update($dados);

        return $unidade;
    }

    /**
     * Exclui uma unidade.
     *
     * @param int $id
     *
     * @return bool|null
     */
    public function excluir($id)
    {
        return Unidade::find($id)->delete();
    }
}
