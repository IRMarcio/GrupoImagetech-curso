<?php


namespace App\Traits;


use App\Models\Estocagem;
use App\Models\EstocagemEndAlocacao;
use App\Models\EstoqueMovimento;
use App\Models\TabEndLocacao;
use phpDocumentor\Reflection\Types\Boolean;

trait UpdateTrasnferenciaEnderecoDataTrait
{

    /**
     * @var ...Global
     * */
    // @var $data
    public $data = null;
    // @var $estocagens;
    private $estocagens = null;
    // @var $modelEndereco;
    private $modelEndereco = null;

    //@var $transferenciaMode;
    private $transferenciaMode = null;


    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
        $this->setEstocagens(json_decode($data['estocagens'], true));
        $this->modelEndereco = TabEndLocacao::find((int)$this->data['id']);
    }

    /**
     * @param null $estocagens
     */
    public function setEstocagens($estocagens): void
    {
        $this->estocagens = $estocagens;
    }

    /**
     *
     * */
    public function gerarEstruturaUpdateTransferencia()
    {
        return collect([
            $this->update(),
            $this->transferenciaEndereco(),
        ]);

    }

    /**
     * @return Boolean;
     * *@see Executa Update na Tabela de TabEndLocacao -> produtos, caixas, paletes;
     *
     */
    public function update()
    {
        $data = collect($this->data)->only(['produtos', 'caixas', 'paletes'])->toArray();
        return $this->modelEndereco->update($data);
    }

    /**
     * @return \Illuminate\Support\Collection;
     * *@see Executa Transferência de Cargas de Endereços quando solicitado pelo usuário;
     */
    public function transferenciaEndereco()
    {
        return collect($this->estocagens)->each(function ($item) {
            $this->transferenciaMode = ($item['quantidade_atual'] == 0) ? true : false;
            $this->executaTransferencia($item);
        });
    }

    /**
     * @param $item ;
     *
     * @return array|void;
     * *@see Executa Transferencia de Cargas de acordo com a estrutura fornecida;
     */
    private function executaTransferencia($item)
    {
        return $this->transferenciaMode ?
            $this->transferenciaPassiva($item) : $this->transferenciaAtiva($item);
    }

    /**
     * @param $item ;
     * @return array|void
     ** @see TransferenciaPassiva -> é quando a carga movida total para o endereço alocado;
     */
    private function transferenciaPassiva($item)
    {
        return EstocagemEndAlocacao::find($item['carga']['id'])->update(
            [
                'end_alocacao_id' => $item['re_alocacao']
            ]
        );
    }

    /**
     * @param $item ;
     * @return array|void
     * *@see TransferenciaAtiva -> é quando a carga é trasnferida Parcial, gerando uma nova rede de registros para o lote;
     */
    private function transferenciaAtiva($item)
    {

        // Gerar registro Estocagem
        // Gerar registro EstocagemEndLocacao
        // Alterar Quantidade Estoque Movimento
        // Gerar EstoqueMovimento
        $estocagem = Estocagem::find($item['carga']['estocagem_id']);
        return collect([
            $estocagem = $this->_transfPrimeiroProcesso($estocagem),
            $this->_transfSegundoProcesso($estocagem, $item),
            $this->_transfTerceiroProcesso($item),
            $this->_transfQuartoProcesso($estocagem, $item),
        ]);
    }

    private function _transfPrimeiroProcesso($estocagem)
    {
        return Estocagem::create([
            'relacao_produto_carga_id' => $estocagem->relacao_produto_carga_id,
            'previsao_entrega_id' => $estocagem->previsao_entrega_id,
            'responsavel_user_id' => auth()->user()->id,
        ]);
    }

    private function _transfSegundoProcesso($estocagem, $item)
    {
        return $estocagem->estocagem_end_locacao()->create([
            'end_alocacao_id' => $item['re_alocacao'],
            'estocagem_id' => $estocagem->id,
        ]);
    }

    private function _transfTerceiroProcesso($item)
    {
        $movimento = EstoqueMovimento::find($item['movimento_id']);
        return $movimento->update([
            "transferido" => ($movimento->transferido + $item['quantidade_selecionada']),
            "quantidade_movimento" => $item['quantidade_atual']
        ]);

    }

    private function _transfQuartoProcesso($estocagem, $item)
    {
        return EstoqueMovimento::create([
                "data_validade_lote" => $item['data_validade_lote'],
                "catmat_id" => $item['id'],
                "tipo_movimento" => 3,
                "transferido" => 0,
                "quantidade_movimento" => $item['quantidade_selecionada'],
                "estocagem_id" => $estocagem->id,
            ]);
    }

}