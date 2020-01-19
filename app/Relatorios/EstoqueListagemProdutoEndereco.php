<?php

namespace App\Relatorios;

use App\Models\Estocagem;
use App\Models\EstocagemEndAlocacao;
use App\Models\EstoqueInventario;
use App\Models\TabRelacaoProdutoCarga;
use App\Relatorios\RelatorioBase;
use App\Models\Estoque;
use App\Models\Unidade;
use mysql_xdevapi\Collection;

class EstoqueListagemProdutoEndereco extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Estoque';

    /**
     * Quantidade de itens por página.
     *
     * @var int
     */
    protected $porPagina = 20;

    /**
     * A view utilizada para impressão deste relatório.
     *
     * @var string
     */
    protected $view = 'relatorios.estoque.imprimir';

    /**
     * Gera os dados.
     *
     * @param  array  $filtros
     * @param  bool  $paginar
     * @param  array  $with
     *
     * @return mixed
     */
    public function gerar($filtros, $paginar = true, $with = [], $stech = true)
    {

        if ($stech) {
            if (empty($filtros['unidade_id']) && empty($filtros['secao_id'])) {
                return collect();
            }
        }

        $registros = $this->getData($with, $filtros);

        if (!empty($filtros['com_estoque'])) {
            $registros->where('quantidade', '>', 0);
        }

        if (!empty($filtros['descricao_produto'])) {
            $registros->whereHas('produto.catmat', function ($q) use ($filtros) {
                $q->where('descricao', 'LIKE', '%'.$filtros['descricao_produto'].'%');
            });
        }

        if (!empty($filtros['data_validade'])) {
            $registros->whereHas('produto', function ($q) use ($filtros) {
                $q->where('data_validade', '=', formatarData($filtros['data_validade'], 'Y-m-d'));
            });
        }

        if (!empty($filtros['id_catmat'])) {
            $registros->whereHas('catmat', function ($q) use ($filtros) {
                $q->where('id', 'LIKE', '%'.$filtros['id_catmat'].'%');
            });
        }

        if (!empty($filtros['codigo_catmat'])) {
            $registros->whereHas('catmat', function ($q) use ($filtros) {
                $q->where('codigo', 'LIKE', '%'.$filtros['codigo_catmat'].'%');
            });
        }

        if (!empty($filtros['catmat_id'])) {
            $filtros['catmat_id'] = array_wrap($filtros['catmat_id']);
            $registros->whereHas('catmat', function ($q) use ($filtros) {
                $q->whereIn('id', $filtros['catmat_id']);
            });
        }

        if (!empty($filtros['catmat_id_visualizar'])) {
            $registros->where('produto_id', $filtros['catmat_id_visualizar']);
        }


        if ($paginar) {
            return $registros->paginate($this->porPagina);
        }

        return $registros->get();
    }

    public function titulo()
    {
        $unidadeSelecionada = null;
        if (!empty($this->filtros['unidade_id'])) {
            $unidadeSelecionada = ' - Unidade '.Unidade::find($this->filtros['unidade_id'])->descricao;
        }

        return $this->titulo.$unidadeSelecionada;
    }

    private function getData(array $with, $filtros)
    {
        $registro = EstoqueInventario::select(
            'estoque_inventario.*',
            'catmat.descricao'
        )->with(array_merge($with,
                [
                    'relacao_produto_carga',
                    'relacao_produto_carga.estocagem',
                    'relacao_produto_carga.estocagem.estocagem_end_locacao'
                ])
        )
                                     ->join('catmat', 'catmat.id', '=', 'estoque_inventario.id')
                                     ->orderBy('estoque_inventario.centro_distribuicao_id', 'ASC')
                                     ->orderBy('catmat.descricao')
                                     ->orderBy('estoque_inventario.data_validade_lote');
        return $registro;
    }
}
