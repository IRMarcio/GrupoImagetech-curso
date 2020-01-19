<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Models\EntMedicamento;
use App\Models\TabPrevisaoEntrega;

class GerenciaPrevisaoEntrega
{

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    public function __construct(SessaoUsuario $sessaoUsuario)
    {
        $this->sessaoUsuario = $sessaoUsuario;
    }

    public function criar($dados)
    {

        // Persiste previsão de entrega
        $dados['status_previsao'] = TabPrevisaoEntrega::PREVISAO_CHEGADA;

        $entMed = EntMedicamento::find(request()->input('ent_medicamentos_id'));
        $dados['fornecedor_id'] = $entMed->fornecedor_id;


        $previsaoEntrega = TabPrevisaoEntrega::create($dados);

        // Persiste o TabProdutoCarga
        $produtoCarga = $previsaoEntrega->produtoCarga()->create($dados);


        // Gerencia os produtos da previsão
        $this->gerenciarProdutos($produtoCarga, $dados);

        return $previsaoEntrega;
    }

    public function alterar($registro, $dados)
    {

        $entMed = EntMedicamento::find(request()->input('ent_medicamentos_id'));
        $dados['fornecedor_id'] = $entMed->fornecedor_id;
        $dados['controle_lote'] = isset($dados['controle_lote']) ? 1 : 0;


        // Persiste previsão de entrega
        $registro->update($dados);

        // Persiste o TabProdutoCarga

        $registro->produtoCarga->update($dados);

        // Gerencia os produtos da previsão
        $this->gerenciarProdutos($registro->produtoCarga, $dados);

        return $registro;
    }

    private function gerenciarProdutos($produtoCarga, $dados)
    {
        $arrayFormatado = [];
        if (!empty($dados['lotes'])) {
            foreach ($dados['lotes'] as $produto) {

                $arrayFormatado[] =
                    [
                        'catmat_id' => $produto['catmat_id'],
                        'data_validade_lote' => $produto['data_validade'],
                        'quantidade' => str_replace(',', '.', $produto['quantidade']),
                        'codigo_barra' => $produto['codigo_barra'],
                        'qtd_caixas' => str_replace(',', '.',$produto['qtd_caixas']),
                        'previsao_chegada' => $produto['previsao_chegada'],
                        'ent_med_lotes_id' => $produto['ent_med_lotes_id'],
                    ];
            }
        }

        $produtoCarga->catmats()->sync($arrayFormatado);
    }

    public function encaminharInspecao($previsaoEntrega)
    {
        return $previsaoEntrega->update(['status_previsao' => TabPrevisaoEntrega::INSPECAO_TRIAGEM]);
    }
}
