<?php

namespace App\Services;

use App\Models\Movimentacao;
use App\Models\SituacaoMovimentacao;

class RecebimentoProduto
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
     * Realiza uma movimentação do tipo recebimento de produtos de outra seção..
     *
     * @param array $dados
     *
     * @return Movimentacao
     */
    public function receber($dados)
    {
        $movimentacao = Movimentacao::with('movimentados')->find($dados['movimentacao_id']);

        // Controlamos aqui qual será a situação final da movimentação dependendo do que acontecer nela.
        $novaSituacao = 'concluida';

        // Agora para cada um dos produtos que o usuário informou ter recebido
        foreach ($dados['produtos'] as $produto) {
            $produto = json_decode($produto);
            if (is_null($produto->quantidade_informada)) {
                continue;
            }

            // Vamos adicionar no estoque da seção de destino o produto
            $estoque = $this->gerenciaEstoque->adicionar(
                $dados['secao_id_destino'],
                $produto->produto_id,
                $produto->quantidade_informada
            );

            $movimentado = $movimentacao->movimentados->where('produto_id', $produto->produto_id)->first();
            $qtdeRecebimento = $movimentado->qtde_recebimento + $produto->quantidade_informada;
            $diferenca = ($movimentado->qtde_envio - $qtdeRecebimento);

            // Se pelo menos um produto foi recebido com alguma diferença (recebeu menos do que enviou)
            if ($diferenca > 0 && $novaSituacao !== 'pendente') {
                $novaSituacao = 'pendente';
            }

            $movimentado->update(
                [
                    'qtde_recebimento'       => $qtdeRecebimento,
                    'qtde_diferenca'         => $diferenca,
                    'estoque_id_destino'     => $estoque->id,
                    'data_recebimento'       => now(config('app.timezone')),
                ]
            );

            // E por fim criamos uma movimentacao de estoque de recebimento
            $movimentado->recebimentos()->create(
                [
                    'qtde_recebimento' => $produto->quantidade_informada,
                    'movimentacao_id' => $movimentado->movimentacao_id,
                    'data_recebimento' => now(config('app.timezone'))
                ]
            );
        }

        // Se ainda existem produtos a receber
        if ($novaSituacao !== 'pendente' && count($movimentacao->produtosReceber) > 0) {
            $novaSituacao = 'pendente';
        }

        $movimentacao = $this->finalizarMovimentacao($dados['movimentacao_id'], $novaSituacao, $dados['secao_id_destino'], $dados['data_recebimento'], $dados['perfil_usuario_id']);

        return $movimentacao;
    }

    /**
     * Marca a movimentação de envio de outra seção como recebida por esta.
     *
     * @param int $idMovimentacao
     * @param string $novaSituacao
     * @param int $idSecaoDestino
     * @param string $dataRecebimento
     * @param int $idPerfilUsuario
     *
     * @return Movimentacao
     */
    private function finalizarMovimentacao($idMovimentacao, $novaSituacao, $idSecaoDestino, $dataRecebimento, $idPerfilUsuario)
    {
        $movimentacao = Movimentacao::find($idMovimentacao);
        $movimentacao->update(
            [
                'data_recebimento'              => $dataRecebimento,
                'data_registro_recebimento'     => now(config('app.timezone')),
                'situacao_movimentacao_id'      => SituacaoMovimentacao::whereSlug($novaSituacao)->first()->id,
                'secao_id_destino'              => $idSecaoDestino,
                'perfil_usuario_id_recebimento' => $idPerfilUsuario
            ]
        );

        return $movimentacao;
    }
}
