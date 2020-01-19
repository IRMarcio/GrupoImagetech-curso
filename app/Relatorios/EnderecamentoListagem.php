<?php

namespace App\Relatorios;

use App\Relatorios\RelatorioBase;
use App\Models\Enderecamento;

class EnderecamentoListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Endereçamento';

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
    protected $view = 'enderecamento.imprimir';

    /**
     * Gera os dados.
     *
     * @param array $filtros
     * @param bool $paginar
     * @param array $with
     *
     * @return mixed
     */
    public function gerar($filtros, $paginar = true, $with = [])
    {
        $registros = Enderecamento::select('enderecamento.*')
                              ->with($with)
                              ->leftJoin('tipo_produto', 'tipo_produto.id', '=', 'enderecamento.tipo_produto_id')
                              ->orderBy('tipo_produto.descricao', 'ASC');
                              
        if (!empty($filtros['tipo_produto_id'])) {
            $registros->where('enderecamento.tipo_produto_id', $filtros['tipo_produto_id']);
        }

        if (!empty($filtros['secao_id'])) {
            $registros->where('enderecamento.secao_id', $filtros['secao_id']);
        }

        if (!empty($filtros['unidade_id'])) {
            $registros->whereHas('secao', function($q) use ($filtros) {
                $q->where('secao.unidade_id', $filtros['unidade_id']);
            });
        }

        if ($paginar) {
            return $registros->paginate($this->porPagina);
        }

        return $registros->get();
    }
}
