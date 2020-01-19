<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Models\Unidade;
use App\Models\Secao;

class GerenciaUnidadeSecao
{
    /**
     * Cria registro de seção
     *
     * @param Unidade $unidade
     * @param array $dados
     *
     * @return Secao
     */
    public function criar(Unidade $unidade, $dados)
    {
        return $unidade->secoes()->create($dados);
    }

    /**
     * Altera registro de seção
     *
     * @param int $secaoId
     * @param array $dados
     *
     * @return Secao
     */
    public function alterar($secaoId, $dados)
    {
        $secao = Secao::findOrFail($secaoId);
        $secao->update($dados);

        return $secao;
    }
}
