<?php


namespace App\Traits;

//use App\Models\ConhecimentoEmbarque;
//use App\Models\EntMedicamento;
//use App\Models\Estocagem;
//use App\Models\Estoque;
//use App\Models\EstoqueInventario;
//use App\Models\EstoqueMovimento;
//use App\Models\ListaEmbalagensProdutos;
use App\Models\Secao;
use App\Models\TabCentroDistribuicao;
use App\Models\TabPrevisaoEntrega;
use App\Models\Unidade;
use App\Services\SessaoUsuario;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Trait utilizada em estrutura que se repete para se fazer a leitura de retorno de DADOS do Usuário logado.
 *
 * @return Estoque;
 * @return EstoqueMovimento;
 * @return Unidade;
 * @return Secao;
 * @return Estocagem;
 *
 * @package \Operations in structure
 *
 */
trait DashboardAgenteTrait
{

    /**
     * @var EstoqueMovimento
     */
    private $movimento;
    /**
     * @var Estocagem
     */
    private $estocagem;
    /**
     * @var TabPrevisaoEntrega
     */
    private $previsaoEntrega;

    /**
     * @var TabCentroDistribuicao
     */
    private $centro;

    /**
     *  set Centro de Distribuição para Estrutura de Dashboard;
     *
     * @return  SessaoUsuario->TabCentroDistribuicao
     */
    public function setCentro()
    {
        $this->centro = !$this->sessaoUsuario->centroDistribuicao() ? null : $this->sessaoUsuario->centroDistribuicao()->id;
    }

    /**
     * Formatar saída da estrutura para view Dashboard->(chart)
     *
     * @return DashboardAgenteTrait
     * */
    public function formatDataDashboard(): Collection
    {
        return $this->getResourceDataDashboard(collect([
            'produtos' => 0,//$this->catMat->count(),
            'estoque_movimento' => 0,//$this->estoque_movimento_count(),
            'estoque' => 0,//$this->estoque_inventario_soma_quantidade(),
            'transferencias' => 0,// $this->transferenciaListaEmbalagens(),
            'chartMovimento' => 0,// $this->getChartMovimento(),
            'chartEstoque' => 0,// $this->getChartEstoque(),
            'chartTransferencia' => 0,// $this->getChartTransferencia(),
            'produtos_total' => 0,// $this->getChartEstoqueProdutos()
        ]));
    }

    /**
     * Formatar saída da estrutura para view Dashboard->(chart)
     *
     * @return Collection
     * */
    public function guestDadosLogisticaExpedicao($centro)
    {
        return $this->getResourceDataDashboard(collect([
            'recebimento_insumos' => 0, // $this->getRecebimento_insumos($centro),
            'previsao_entrega' => 0, // $this->getPrevisaoEntrega($centro),
            'controle_portaria' => 0, // $this->getControlePortaria($centro),
            'inspecao_triagem' => 0, // $this->getInspecaoTriagem($centro),
            'estocagem' => 0, // $this->getEstocagem($centro),
            'conhecimento_embarque' => 0, // $this->getConhecimentoEmbarque($centro),
            'nota_despacho' => 0, // $this->getNotaDespacho($centro),
            'lista_embalagens' => 0, // $this->getListaEmbalagens($centro),
            'expedicao' => 0, // $this->getExpedicao($centro),
            'manifesto_expedicao' => 0, // $this->getManifestoExpedicao($centro)
        ]));


    }

    /**
     * Retorna Total de Estoque Movimento da model EstoqueMovimento, do centro ativo;
     *
     * @required $this->centro
     * @return EstoqueMovimento;
     */
    public function estoque_movimento_count()
    {
        return EstoqueMovimento::whereHas('estocagem.previsao_entrega', function ($q) {
            $q->where('centro_distribuicao_id', $this->centro);
        })->sum('quantidade_movimento');
    }

    /**
     * Retorna Total de Recebimentos de Insumos, do centro ativo;
     *
     * @required $this->centro
     * @return array
     */
    public function getRecebimento_insumos($centro)
    {
        $entrada = EntMedicamento::with('previsaoEntrega')
            ->where('centro_distribuicao_id', $centro)
            ->whereDoesntHave('previsaoEntrega')->count();

        $encaminhado = EntMedicamento::with('previsaoEntrega')
            ->where('centro_distribuicao_id', $centro)
            ->whereHas('previsaoEntrega')->count();

        return collect($entrada)
            ->push($encaminhado);
    }

    /**
     * Retorna Total de Previsão de Entrega, do centro ativo;
     *
     * @required $this->centro
     * @return int
     */
    public function getPrevisaoEntrega($centro)
    {
        return TabPrevisaoEntrega::where('centro_distribuicao_id', $centro)
            ->whereBetween('status_previsao', [TabPrevisaoEntrega::PREVISAO_CHEGADA, TabPrevisaoEntrega::ESTOCAGEM])
            ->count();
    }

    /**
     * Retorna Total de Controle Portaria Pendente, do centro ativo;
     *
     * @required $this->centro
     * @return int
     */
    public function getControlePortaria($centro)
    {
        return TabPrevisaoEntrega::where('centro_distribuicao_id', $centro)
            ->whereStatusPrevisao(1)
            ->count();
    }

    /**
     * Retorna Total de Inspeção/Triagem, do centro ativo;
     *
     * @required $this->centro
     * @return int
     */
    public function getInspecaoTriagem($centro)
    {
        return TabPrevisaoEntrega::where('centro_distribuicao_id', $centro)
            ->whereStatusPrevisao(2)
            ->count();
    }

    /**
     * Retorna Total de Inspeção/Triagem, do centro ativo;
     *
     * @required $this->centro
     * @return int
     */
    public function getConhecimentoEmbarque($centro)
    {
        $entrada = ConhecimentoEmbarque::where('centro_distribuicao_id', $centro)
            ->whereBetween('status', [ConhecimentoEmbarque::NOTA_DESPACHO, ConhecimentoEmbarque::MANIFESTO_EXPEDICAO])
            ->count();
        $encaminhados = ConhecimentoEmbarque::where('centro_distribuicao_id', $centro)
            ->where('status', "!=", ConhecimentoEmbarque::NOTA_DESPACHO)
            ->count();
        return collect($entrada)->push($encaminhados);
    }

    /**
     * Retorna Total de ConhecimentoEmbarque->nota_despacho, do centro ativo;
     *
     * @required $this->centro
     * @return int
     */
    public function getNotaDespacho($centro)
    {
        return ConhecimentoEmbarque::where('centro_distribuicao_id', $centro)
            ->whereStatus(ConhecimentoEmbarque::NOTA_DESPACHO)
            ->count();
    }

    /**
     * Retorna Total de ConhecimentoEmbarque->lista_embalagens, do centro ativo;
     *
     * @required $this->centro
     * @return int
     */
    public function getListaEmbalagens($centro)
    {
        return ConhecimentoEmbarque::where('centro_distribuicao_id', $centro)
            ->whereStatus(ConhecimentoEmbarque::LISTA_EMBALAGEM)
            ->count();
    }

    /**
     * Retorna Total de ConhecimentoEmbarque->expedicao, do centro ativo;
     *
     * @required $this->centro
     * @return int
     */
    public function getExpedicao($centro)
    {
        return ConhecimentoEmbarque::where('centro_distribuicao_id', $centro)
            ->whereStatus(ConhecimentoEmbarque::EXPEDICAO)
            ->count();
    }

    /**
     * Retorna Total de ConhecimentoEmbarque->expedicao, do centro ativo;
     *
     * @required $this->centro
     * @return int
     */
    public function getManifestoExpedicao($centro)
    {
        return ConhecimentoEmbarque::where('centro_distribuicao_id', $centro)
            ->whereStatus(ConhecimentoEmbarque::MANIFESTO_EXPEDICAO)
            ->count();
    }

    /**
     * Retorna Total de Estocagem, do centro ativo;
     *
     * @required $this->centro
     * @return int
     */
    public function getEstocagem($centro)
    {
        return TabPrevisaoEntrega::where('centro_distribuicao_id', $centro)
            ->whereStatusPrevisao(3)
            ->count();
    }

    /**
     * Retorna Soma de quantidade  de Estoque Inventário da model EstoqueInventario, do centro ativo;
     *
     * @required $this->centro
     * @return EstoqueInventario;
     */
    public function estoque_inventario_soma_quantidade()
    {
        return EstoqueInventario::where('centro_distribuicao_id', $this->centro)->sum('quantidade');
    }

    /**
     * Retorna soma de quantidade de ListaEmbalagensProdutos , do centro ativo;
     *
     * @required $this->centro
     * @return EstoqueMovimento;
     */
    public function transferenciaListaEmbalagens()
    {
        return ListaEmbalagensProdutos::WhereHas('embalagem.conhecimento_embarque',
            function ($q) {
                $q->where('centro_distribuicao_id', $this->centro);
            })->sum('quantidade');
    }

    /**
     * Retorna soma de quantidade de movimento EstoqueMovimento , do centro ativo;
     *
     * @required $this->centro
     * @return array;
     */
    public function getChartMovimento()
    {
        return $this->getChartValues(
            $this->movimento,
            'estocagem.previsao_entrega',
            $this->centro,
            'created_at',
            'quantidade_movimento'
        );
    }

    /**
     * Retorna soma de quantidade de Produtos EstoqueInventário, do centro ativo;
     *
     * @required $this->centro
     * @return array;
     */
    public function getChartEstoque()
    {
        return $this->getChartValues(
            $this->estoqueInventario->where('centro_distribuicao_id', $this->centro),
            null,
            null,
            'created_at',
            'quantidade');
    }

    /**
     * Retorna soma de quantidade de ListaEmbalagensProduto, do centro ativo;
     *
     * @required $this->centro
     * @return array;
     */
    public function getChartTransferencia()
    {
        return $this->getChartValues(
            $this->transferencia,
            'embalagem.conhecimento_embarque',
            $this->centro,
            'created_at',
            'quantidade');
    }

    /**
     * Retorna array formatado da query solicitada ;
     *
     * @param $model ,$whereHas,$condition, $column, $columnValue;
     * @required $this->centro
     * @return array;
     */
    private function getChartValues($model, $whereHas, $condition, string $column, $columnValue)
    {
        $mesFormat = DB::raw("DATE_FORMAT(" . $column . ", '%m') as mes");
        $totalFormat = DB::raw("SUM(" . $columnValue . ") as total");

        $start = now()->startOfYear();
        $end = now()->endOfYear();

        $dates = [];

        $run = $start->copy();
        while ($run->lte($end)) {
            $dates = array_add($dates, $run->copy()->format('m'), '0');
            $run->addMonth(1);
        }

        $res = $model->select($mesFormat, $totalFormat);

        if ($whereHas) {
            $res = $res->whereHas($whereHas, function ($query) use ($condition) {
                $query->where('centro_distribuicao_id', $condition);
            });
        }

        $res = $res->groupBy('mes')
            ->pluck('total', 'mes');


        $all = $res->toArray() + $dates;
        ksort($all);

        return array_values($all);
    }

    /**
     * Retorna soma de quantidade de Produtos EstoqueInventário, do centro ativo;
     *
     * @required $this->centro
     * @return array;
     */
    public function getChartEstoqueProdutos()
    {
        return $this->getChartValuesProdutos(
            $this->estoqueInventario->where('centro_distribuicao_id', $this->centro),
            null,
            null,
            'quantidade'
        );
    }


    /**
     * Retorna array formatado da query solicitada ;
     *
     * @param $model ,$whereHas,$condition, $column, $columnValue;
     * @required $this->centro
     * @return array;
     */
    private function getChartValuesProdutos($model, $whereHas, $condition, $columnValue)
    {

        $total = DB::raw("SUM(" . $columnValue . ") as total");
        $modelo = [];
        $res = $model->select(
            $total,
            DB::raw("LEFT(catmat.descricao, 40) as descricao")
        )->join('catmat', 'catmat.id', '=', 'estoque_inventario.produto_id');

        if ($whereHas) {
            $res = $res->whereHas($whereHas, function ($query) use ($condition) {
                $query->where('centro_distribuicao_id', $condition);
            });
        }

        $res = $res->groupBy('catmat.descricao')
            ->orderBy('total', 'ASC')
            ->limit(10)
            ->pluck('total', 'catmat.descricao');

        $all = $res->toArray();
        ksort($all);
        $modelo['key'] = array_keys($all);
        $modelo['value'] = array_values($all);

        return $modelo;
    }

    private function getResourceDataDashboard(Collection $collect)
    {
        $icon = false;
        foreach ($this->getArraySearchfor() as $item) {
            if (isset($collect[$item]))
                $collect[$item] === 0 ?: $icon = true;
        }
        return $collect->merge(['icon' => $icon]);
    }

    private function getArraySearchfor()
    {
        return
            [
                'previsao_entrega', 'controle_portaria', 'inspecao_triagem', 'estocagem',
                'nota_despacho', 'lista_embalagens', 'lista_embalagens', 'manifesto_expedicao', 'expedicao'
            ];
    }

}
