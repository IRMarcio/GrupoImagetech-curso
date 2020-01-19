<?php

namespace App\Relatorios;

use App\Models\ConhecimentoEmbarque;
use App\Services\SessaoUsuario;

class ConhecimentoEmbarqueListagem extends RelatorioBase
{

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    public function __construct(SessaoUsuario $sessaoUsuario)
    {
        $this->sessaoUsuario = $sessaoUsuario;
    }

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Conhecimento de Embarque';

    /**
     * Quantidade de itens por página.
     *
     * @var int
     */
    protected $porPagina = 10;

    /**
     * A view utilizada para impressão deste relatório.
     *
     * @var string
     */
    protected $view = 'conhecimento_embarque.imprimir';

    /**
     * Gera os dados.
     *
     * @param array $filtros
     * @param bool $paginar
     *
     * @return mixed
     */
    public function gerar($filtros, $paginar = true)
    {
        $registros = ConhecimentoEmbarque::with('cliente', 'expedicao')->whereCentroDistribuicaoId($this->sessaoUsuario->centroDistribuicao()->id)->orderBy('data_entrega', 'ASC');

        if (!empty($filtros['status'])) {
            $registros->where('status', $filtros['status']);
        }

        $registros->orderBy('created_at', 'asc');
        if ($paginar) {
            return $registros->paginate($this->porPagina);
        }

        return $registros->get();
    }
}
