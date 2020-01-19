<?php

namespace App\Http\Middleware;

use App\Services\CentroDistribuicaoUnidade;
use App\Services\PerfilPrincipal;
use App\Services\SessaoUsuario;
use Closure;

class DescobrirCentroDistribuicao
{

    /**
     * @var PerfilPrincipal
     */
    private $perfilPrincipal;

    protected $count = 0;

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    /**
     * @var CentroDistribuicaoUnidade
     */
    private $centroDistribuicao;

    public function __construct(
        CentroDistribuicaoUnidade $centroDistribuicao,
        SessaoUsuario $sessaoUsuario
    ) {

        $this->sessaoUsuario = $sessaoUsuario;
        $this->centroDistribuicao = $centroDistribuicao;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {

        // Se estivermos na própria rota de selecionar unidade, vamos ignorar e continuar a requisição
        $routeName = $request->route()->getName();

        $centroDistribuicao = null;

        /*Descobre a Rota Atual*/
        $routeName = $request->route()->getName();

        //Busca usuario logado;
        $usuarioLogado = auth()->user();


        if (
            auth()->check() &&
            !app()->runningInConsole() &&
            !request()->wantsJson()
        ) {
            // Queremos setar o centro de distribuição se a mesmo for nulo ou ainda não foi setada
            $centroDistribuicao = $this->centroDistribuicao->descobrirCentroDistribuicao();
            $this->sessaoUsuario->atualizarDados('centro_distribuicao', $centroDistribuicao);

            if (strpos($routeName, "dashboard") !== false || strpos($routeName, "selecionar_unidade") !== false) {
                if (!$centroDistribuicao) {
                    if ($this->sessaoUsuario->unidade()) {
                        $unidade = $this->sessaoUsuario->unidade()->descricao;
                        flash("Não foi Anexado Centro de Distribuição para  $unidade, Entre em contato com departamento de TI.")->warning();
                    }
                }

                return $next($request);
            }

            // Se não tiver selecionado centro de distribuição , só deixa passar se usuário logado for super_admin
            if (is_null($centroDistribuicao) && !$usuarioLogado->super_admin) {
                flash('Ainda não foi selecionado o Centro de Distribuição para sua Unidade, Entre em contato com departamento de TI.')->important();

                return redirect()->route('dashboard');
            }

            // Evitando erros de sistema em Rotas Imprórprias no Início do Processo de Cadastro de Dependências do Sistema;
            if (is_null($centroDistribuicao) && in_array($routeName, $this->getRoutesInpropria())) {
                flash('Ainda não foi selecionado o Centro de Distribuição para sua Unidade, Entre em contato com departamento de TI.')->important();

                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }

    /**
     * Estrutura de Arrays de Rotas dispensadas no inicio de processo de cadastro do sistema,
     * se Centro de Distribuição não alocado para o usuário;
     *
     * @return array;
     * */
    private function getRoutesInpropria(): array
    {
        return [
            "pedidos.index",
            "pedidos.requerimento_index",
            "agenda_insumos.index",
            "entrada_medicamentos.index",
            "insumos_compras.index",
            "insumos_compras.pedidos",
            "conhecimento_embarque.index",
            "nota_despacho.index",
            "expedicao.index",
            "manifesto_expedicao.index"
        ];
    }
}
