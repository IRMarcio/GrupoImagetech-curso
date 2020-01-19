<?php

namespace App\Services;

use App\Models\Movimentacao;
use App\Models\SituacaoMovimentacao;

class BaixaProduto
{

    /**
     * @var GerenciaEstoque
     */
    private $gerenciaEstoque;

    public function __construct(GerenciaEstoque $gerenciaEstoque)
    {
        $this->gerenciaEstoque = $gerenciaEstoque;
    }

    /**
     * Realiza baixa no estoque do(s) produto(s) informado(s).
     *
     * @param array $dados
     *
     * @return Movimentacao
     * @throws \Exception
     */
    public function baixar($dados)
    {
        $movimentacao = $this->criarMovimentacao(
            $dados['unidade_id_destino'],
            $dados['secao_id_destino'],
            $dados['tipo_movimentacao_id'],
            $dados['observacao'],
            $dados['perfil_usuario_id'],
            $dados['data_saida']
        );

        foreach ($dados['produtos'] as $produto) {
            $produto = json_decode($produto);
            if (is_null($produto->quantidade_informada)) {
                continue;
            }

            // Vamos subtrair a quantidade informada pelo usuário do produto
            $estoque = $this->gerenciaEstoque->subtrair(
                $dados['secao_id_destino'],
                $produto->produto_id,
                $produto->quantidade_informada
            );

            $movimentacao->movimentados()->create(
                [
                    'estoque_id_origem'  => $estoque->id,
                    'estoque_id_destino' => $estoque->id,
                    'produto_id'         => $estoque->produto_id,
                    'qtde_envio'         => $produto->quantidade_informada
                ]
            );
        }

        return $movimentacao;
    }

    /**
     * Cria a movimentação.
     *
     * @param int $idUnidadeDestino
     * @param int $idSecaoDestino
     * @param int $idTipoMovimentacao
     * @param string $observacao
     * @param string $idPerfilUsuarioId
     * @param string $dataSaida
     *
     * @return Movimentacao
     */
    private function criarMovimentacao($idUnidadeDestino, $idSecaoDestino, $idTipoMovimentacao, $observacao, $idPerfilUsuarioId, $dataSaida)
    {
        return Movimentacao::create(
            [
                'observacao'                => $observacao,
                'unidade_id_origem'         => $idUnidadeDestino,
                'unidade_id_destino'        => $idUnidadeDestino,
                'secao_id_origem'           => $idSecaoDestino,
                'secao_id_destino'          => $idSecaoDestino,
                'data_saida'                => $dataSaida,
                'data_registro_saida'       => now(config('app.timezone')),
                'situacao_movimentacao_id'  => SituacaoMovimentacao::where('slug', 'concluida')->first()->id,
                'tipo_movimentacao_id'      => $idTipoMovimentacao,
                'perfil_usuario_id_saida'   => $idPerfilUsuarioId,
            ]
        );
    }
}
