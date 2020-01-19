<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SalvarUnidadeRequest;
use App\Models\Unidade;
use App\Models\Municipio;
use App\Relatorios\UnidadeListagem;
use App\Services\GerenciaUnidade;
use App\Services\SessaoUsuario;

class UnidadeController extends Controller
{

    /**
     * @var SessaoUsuario
     */
    protected $sessaoUsuario;

    /**
     * @var UnidadeListagem
     */
    private $listagem;

    /**
     * @var \App\Services\GerenciaUnidade
     */
    private $gerenciaUnidade;

    public function __construct(
        UnidadeListagem $listagem,
        GerenciaUnidade $gerenciaUnidade,
        SessaoUsuario $sessaoUsuario
    ) {
        parent::__construct();

        $this->listagem = $listagem;
        $this->gerenciaUnidade = $gerenciaUnidade;
        $this->sessaoUsuario = $sessaoUsuario;
    }

    /**
     * Lista todos os registros do sistema.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Caso usuário logado não seja gestor nem super_admin, redirecionar para alteração dos dados
        // Da unidade em que está logado
        $usuarioLogado = auth()->user();

        if (!($usuarioLogado->super_admin)) {
            $dados = $this->sessaoUsuario->unidade();
            return redirect()->route('unidade.alterar', $dados->slug());
        }

        $filtros = request()->all();
        if (isset($filtros['acao']) && $filtros['acao'] == 'imprimir') {
            return $this->listagem->exportar($filtros);
        }

        $dados = $this->listagem->gerar($filtros);

        return view('unidade.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @param Unidade|null $unidade
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \ReflectionException
     */
    public function adicionar(Unidade $unidade = null)
    {
        if (is_null($unidade)) {
            // Gera um registro temporário para ser usado
            $unidade = Unidade::gerarTemporario();
        }

        $dependencias = $this->buscarDadosCadastro($unidade);

        return view('unidade.adicionar', compact('unidade', 'dependencias'));
    }

    /**
     * Busca os dados utilizados para o cadastro/alteração de unidade.
     *
     * @param Unidade|null $unidade
     *
     * @return array
     */
    protected function buscarDadosCadastro(Unidade $unidade = null)
    {
        return $this->gerenciaUnidade->carregarDependencias($unidade);
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarUnidadeRequest $request
     * @param Unidade $unidade
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarUnidadeRequest $request, Unidade $unidade)
    {

        $registro = DB::transaction(function () use ($request, $unidade) {
            return $this->gerenciaUnidade->criar($unidade, $request->all());
        });

        if (!$registro->id) {
            flash('Falha na gravação. Favor entrar em contato com o suporte técnico.')->error();

            return back()->withInput();
        }

        flash('Registro salvo com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'unidade', $registro);
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarUnidadeRequest $request
     * @param Unidade $unidade
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addSeederRequest($request, Unidade $unidade, $secoes)
    {

        $registro = DB::transaction(function () use ($request, $unidade) {
            return $this->gerenciaUnidade->criar($unidade, $request);
        });

        $unidade->secoes()->create($secoes);

        if (!$registro->id) {
            flash('Falha na gravação. Favor entrar em contato com o suporte técnico.')->error();
        }

    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param \App\Models\Unidade $unidade
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterar(Unidade $unidade)
    {
        $dependencias = $this->buscarDadosCadastro($unidade);

        return view('unidade.alterar', compact('unidade', 'dependencias'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param \App\Models\Unidade $registro
     * @param SalvarUnidadeRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar(Unidade $registro, SalvarUnidadeRequest $request)
    {
        $dados = $request->all();
        $atualizado = DB::transaction(function () use ($dados, $registro) {
            return $this->gerenciaUnidade->alterar($registro->id, $dados);
        });

        if (!$atualizado) {
            flash('Falha na atualização. Favor entrar em contato com o suporte técnico.')->error();

            return back()->withInput();
        }

        flash('Os dados do registro foram alterados com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'unidade', $registro);
    }

    /**
     * Exclui um registro.
     *
     * @param \App\Models\Unidade $registro
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function excluir(Unidade $registro)
    {
        $excluido = $this->gerenciaUnidade->excluir($registro->id);
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
        $ids = request('ids');
        $registros = Unidade::whereIn('id', $ids)->get();
        $excluido = $this->excluirVariosRegistros($registros);
        if (!$excluido) {
            return response()->json(['sucesso' => false]);
        }

        flash('Os registros foram excluídos com sucesso.')->success();

        return response()->json(['sucesso' => true]);
    }

    /**
     * Carrega as seções da unidade informada
     *
     * @return JsonResponse
     */
    public function carregarSecoes()
    {
        $dados = request()->all();
        $unidade = Unidade::findOrFail($dados['unidade_id']);

        return response()->json(['data' => $unidade->secoes]);
    }
}
