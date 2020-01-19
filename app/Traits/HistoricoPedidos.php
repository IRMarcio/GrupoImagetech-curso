<?php declare(strict_types = 1);


namespace App\Traits;


use App\Models\EntPedidos;
use App\Models\EntPedidosRequerimento;

trait HistoricoPedidos
{

    /**
     * @var $descricao_create_pedido ;
     */
    protected $descricao_create_pedido = "Pedido Gerado na MATRIZ com Sucesso.";

    /**
     * @var $descricao_pedido_visualizado ;
     */
    protected $descricao_pedido_visualizado = "Pedido Visualizado MATRIZ.";

    /**
     * @var $descricao_pedido_requerimento_enviado ;
     */
    protected $descricao_pedido_requerimento_enviado = "Requerimento Enviado com sucesso para, ";

    /**
     * @var $descricao_pedido_requerimento_retorno_negado ;
     */
    protected $descricao_pedido_requerimento_retorno_negado = "Retorno de Requerimento Indisponível Enviar Insumo.";

    /**
     * @var $descricao_requerimento_recusado ;
     */
    protected $descricao_requerimento_recusado = "Requerimento Recusado por Falta de Insumo";

    /**
     * @var $descricao_requerimento_visualizado ;
     */
    protected $descricao_requerimento_visualizado = "Requerimento Visualizado com sucesso no, ";

    /**
     * @var $descricao_pedido_cancelado ;
     */
    protected $descricao_pedido_cancelado = "Pedido Cancelado por Falta de Insumo";

    /**
     * @var $descricao_requerimento_ok ;
     */
    protected $descricao_requerimento_ok = "Retorno de Requerimento Atende Pedido OK";

    /**
     * @var $descricao_requerimento_ok_parcial ;
     */
    protected $descricao_requerimento_ok_parcial = "Requerimento Finalizado Atende Pedido Parcial";

    /**
     * @param $tipo
     * @param $descricao
     * @param $annotation
     * @param $icon
     * @param  EntPedidos  $pedido
     * @param  EntPedidosRequerimento|null  $requerimento
     *
     * @return array ;
     * @see Gera estrutura de Cadastro de Histórico de Pedidos;
     */
    public function getCreateHistorico($tipo, $descricao, $annotation, $icon, EntPedidos $pedido, EntPedidosRequerimento $requerimento = null): array
    {
        return $this->getEstruturaCadastroHistorico($tipo, $this->descricao($descricao), $annotation, $icon, $pedido, $requerimento);
    }

    /**
     *
     * */
    public function getEstruturaCadastroHistorico($tipo, $descricao, $annotation, $icon, $pedido, $requerimento)
    {
        return [
            'tipo_filiacao'                => $tipo,
            'descricao'                    => $annotation ? $descricao.' '.$annotation : $descricao,
            'icon'                         => $icon,
            'ent_pedidos_id'               => $pedido->id,
            'ent_pedidos_requerimentos_id' => isset($requerimento) ? $requerimento->id : null,
        ];
    }

    /**
     * @param $descricao
     *
     * @return string
     * @see Gera Descrição de Cadastro de Histórico de Pedidos;
     *
     */
    private function descricao($descricao)
    {
        switch ($descricao) {
            case $this::CREATE_PEDIDO :
                return $this->descricao_create_pedido;
                break;
            case $this::PEDIDO_VISUALISADO :
                return $this->descricao_pedido_visualizado;
                break;
            case $this::PEDIDO_CANCELADO :
                return $this->descricao_pedido_cancelado;
                break;
            case $this::REQ_ENVIADO :
                return $this->descricao_pedido_requerimento_enviado;
                break;
            case $this::REQ_RETORNO_NEGADO:
                return $this->descricao_pedido_requerimento_retorno_negado;
                break;
            case $this::REQ_RETORNO_RECUSADO:
                return $this->descricao_requerimento_recusado;
                break;
            case $this::REQ_VISUALIZADO:
                return $this->descricao_requerimento_visualizado;
                break;
            case $this::REQ_RETORNO_OK:
                return $this->descricao_requerimento_ok;
                break;
            case $this::REQ_RETORNO_OK_PARCIAL:
                return $this->descricao_requerimento_ok_parcial;
                break;
        }
    }
}
