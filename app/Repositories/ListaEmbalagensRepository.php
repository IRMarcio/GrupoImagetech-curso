<?php


namespace App\Repositories;


use App\Models\ConhecimentoEmbarque;
use App\Models\ListaEmbalagens;
use App\Models\ListaEmbalagensProdutos;
use App\Models\TabPrevisaoEntrega;
use App\Services\GerenciaListaEmbalagensService;
use App\Services\SessaoUsuario;
use function foo\func;
use Illuminate\Support\Collection;

class ListaEmbalagensRepository
{
    protected $modelClass = ListaEmbalagens::class;
    /**
     * @var GerenciaListaEmbalagensService
     */
    private $service;
    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;
    /**
     * @var TabPrevisaoEntrega
     */
    private $entrega;

    public function __construct
    (
        GerenciaListaEmbalagensService $service,
        SessaoUsuario $sessaoUsuario,
        TabPrevisaoEntrega $entrega
    )

    {
        $this->service = $service;
        $this->sessaoUsuario = $sessaoUsuario;
        $this->entrega = $entrega;
    }

    /**
     *  --> segue estrutura de cadastro :
     *
     *        1 -> Busca ListaEmbalagens se existe ou gera um novo modelo;
     *        2 -> Grava todos os registros ListaEmbalagensProdutos da requisição;
     *        3 -> Busca todos os produtos solicitados na requisição para atualizar o estoque(EstoqueInventario);
     *        4 -> NEW Grava todas as demandas da requisição de ListaEmbalagens;
     *        5 -> Atualiza status de ConhecimentoEmbarque;
     *        6 -> Atualiza Estoque Movimento; (falta)
     *        6 -> Atualizar Estocagem End Alocação ; (falta)
     *        7 -> Gerar novo  Estoque Movimento; (falta)
     *        6 -> Finaliza operação;
     *
     * */

    /**
     *
     * */
    public function criar($request)
    {

        /** Recebe os dados $request e encaminha para Logíca de gravação -> GerenciaListaEmbalagensService*/
        return collect($request)->each(function ($item) use ($request) {
            $this->service->getDados($item, $request);
        });

    }

    /**
     * @Função que siponibiliza estrutura de lotes e endereços físico no centro de distribuição de cada CATMAT;
     * @param $embalagem ;
     * @return GerenciaListaEmbalagensService
     * */
    public function gerar(ConhecimentoEmbarque $embalagem)
    {
        $embalagem->load('catmats');

        $idsCatmat = $embalagem->catmats->map(function ($catmat) {
            return $catmat->id;
        })->toArray();

        return $this->service->gerarLotes($idsCatmat);
    }
}
