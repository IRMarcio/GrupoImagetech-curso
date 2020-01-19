<?php

namespace App\Services;

use App\Events\PerfilPrincipalEscolhido;
use App\Models\TabCentroDistribuicao;
use Exception;

class CentroDistribuicaoUnidade
{


    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;
    /**
     * @var TabCentroDistribuicao
     */
    private $centroDistribuicao;

    public function __construct(
        TabCentroDistribuicao $centroDistribuicao,
        SessaoUsuario $sessaoUsuario
    )
    {
        $this->sessaoUsuario = $sessaoUsuario;
        $this->centroDistribuicao = $centroDistribuicao;
    }

    /**
     * Retorna os dados do Centro Distribuição da Unidade principal.
     *
     * @param int|null $centDistId centro distribuição que será definido como principal.
     *
     * @return mixed
     * @throws Exception
     */
    public function descobrirCentroDistribuicao($centDistId = null)
    {

        $usuario = auth()->user();

        //#testar
        if (is_null($centDistId) && !is_null($this->sessaoUsuario->unidade())) {
            $centroDistribuicao = $this->sessaoUsuario->unidade()->centro()->first();
        } else {
            $centroDistribuicao =$this->centroDistribuicao->where('id', $centDistId)->first();
        }

        return $centroDistribuicao;
    }
}
