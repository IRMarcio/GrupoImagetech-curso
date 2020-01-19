<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarAgendaInsumoRequest;
use App\Http\Requests\SalvarVeiculoRequest;
use App\Models\CatMat;
use App\Models\EntAgendaInsumo;
use App\Models\EntMedicamento;
use App\Models\TabCentroDistribuicao;
use App\Models\TabFornecedor;
use App\Models\Usuario;
use App\Models\Veiculo;
use App\Relatorios\AgendaInsumoListagem;
use App\Repositories\AgendaInsumoRepository;
use App\Services\SessaoUsuario;
use Illuminate\Contracts\View\Factory;

class AgendaInsumoController extends Controller
{

    /**
     * @var AgendaInsumoListagem
     */
    private $listagem;

    /**
     * @var AgendaInsumoRepository
     */
    private $repository;

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    /**
     * @var TabCentroDistribuicao
     */
    private $distribuicao;

    public function __construct(
        AgendaInsumoListagem $listagem,
        AgendaInsumoRepository $repository,
        SessaoUsuario $sessaoUsuario,
        TabCentroDistribuicao $distribuicao
    ) {
        parent::__construct();

        $this->listagem = $listagem;
        $this->repository = $repository;
        $this->sessaoUsuario = $sessaoUsuario;
        $this->distribuicao = $distribuicao;
    }

    /**
     * Lista todos os registros do sistema.
     *
     * @return Factory|\Illuminate\View\View
     */
    public function index()
    {
        $filtros = request()->all();
        if (isset($filtros['acao']) && $filtros['acao'] == 'imprimir') {
            return $this->listagem->exportar($filtros);
        }

        $dados = $this->listagem->gerar($filtros);
        $catmats = CatMat::orderBy('descricao', 'ASC')->get();


        return view('agenda_insumos.index', compact('dados', 'filtros', 'catmats'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        $catmats = CatMat::orderBy('descricao', 'ASC')->get();

        return view('agenda_insumos.adicionar', compact('catmats'));
    }

    /**
     * Adiciona um novo registro.
     *
     * @param  SalvarAgendaInsumoRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarAgendaInsumoRequest $request)
    {

        /*Gera entrada de do Centro de distribuição do usuário logado para cadastro de Agenda*/
        $request->offsetSet('centro_distribuicao_id', $this->sessaoUsuario->centroDistribuicao()->id);

        /*Grava Agenda de Insumos no Banco*/
        $registro = $this->repository->create($request->all());

        if (!$registro->id) {
            return back()->withInput();
        }

        flash('Registro salvo com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'agenda_insumos', $registro);
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param  EntAgendaInsumo  $agenda
     *
     * @return Factory|\Illuminate\View\View
     */
    public function alterar(EntAgendaInsumo $agenda)
    {

        $catmats = CatMat::orderBy('descricao', 'ASC')->get();

        return view('agenda_insumos.alterar', compact('agenda', 'catmats'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param  EntAgendaInsumo  $registro
     * @param  SalvarAgendaInsumoRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar(EntAgendaInsumo $registro, SalvarAgendaInsumoRequest $request)
    {
        $atualizado = $this->repository->update($registro, $request->all());
        if (!$atualizado) {
            return back()->withInput();
        }

        flash('Os dados do registro foram alterados com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'agenda_insumos', $registro);
    }

    /**
     * Exclui um registro.
     *
     * @param  EntAgendaInsumo  $registro
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function excluir(EntAgendaInsumo $registro)
    {
        $excluido = $this->repository->delete($registro);
        if (!$excluido) {
            return back()->withInput();
        }

        flash('O registro foi excluído com sucesso.')->success();

        return redirect()->back();
    }

    /**
     * Exclui um ou mais registros selecionados.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function excluirVarios()
    {
        $registros = $this->repository->buscarVariosPorId(request('ids'));
        $excluido = $this->excluirVariosRegistros($registros);
        if (!$excluido) {
            return response()->json(['sucesso' => false]);
        }

        flash('Os registros foram excluídos com sucesso.')->success();

        return response()->json(['sucesso' => true]);
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @param  EntAgendaInsumo|null  $agenda
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function entradaMedicamentos(EntAgendaInsumo $agenda = null)
    {

        $fornecedor = TabFornecedor::all()->pluck('nome_razao_social', 'id');
        $produtos = !$agenda ? Catmat::all() : CatMat::whereId($agenda->catmat_id)->get();
        $parcial = EntMedicamento::$parcial;
        $listaUser = Usuario::all()->pluck('id', 'nome');
        $armazenamento = EntMedicamento::$armazenamento;
        $centros = $this->distribuicao->get();

        return view('entrada_medicamentos.adicionar', compact('armazenamento', 'listaUser', 'parcial', 'fornecedor', 'produtos', 'centros', 'agenda'));
    }
}
