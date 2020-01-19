<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalvarAlunoRequest;
use App\Models\TabEndereco;
use DB;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SalvarFornecedorRequest;
use App\Models\Aluno;
use App\Models\Municipio;
use App\Relatorios\AlunoListagem;
use App\Services\GerenciaAluno;
use App\Services\SessaoUsuario;

class AlunoController extends Controller
{

    /**
     * @var SessaoUsuario
     */
    protected $sessaoUsuario;

    /**
     * @var AlunoListagem
     */
    private $listagem;

    /**
     * @var \App\Services\GerenciaAluno
     */
    private $gerenciaAluno;

    protected $rota;

    public function __construct(
        AlunoListagem $listagem,
        GerenciaAluno $gerenciaAluno,
        SessaoUsuario $sessaoUsuario
    ) {
        parent::__construct();

        $this->listagem = $listagem;
        $this->gerenciaAluno = $gerenciaAluno;
        $this->sessaoUsuario = $sessaoUsuario;
    }

    /**
     * Lista todos os registros do sistema.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $filtros = request()->all();
        $filtros['aluno_transportadora'] = 'F';

        if (isset($filtros['acao']) && $filtros['acao'] == 'imprimir') {
            return $this->listagem->exportar($filtros);
        }

        $dados = $this->listagem->gerar($filtros);

        return view('aluno.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @param  Aluno|null  $aluno
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \ReflectionException
     */
    public function adicionar(Aluno $aluno = null)
    {
        if (is_null($aluno)) {
            // Gera um registro temporário para ser usado
            $aluno = Aluno::gerarTemporario();
        }

        $dependencias = $this->buscarDadosCadastro($aluno);

        return view('aluno.adicionar', compact('aluno', 'dependencias'));
    }

    /**
     * Busca os dados utilizados para o cadastro/alteração de aluno.
     *
     * @param  Aluno|null  $aluno
     *
     * @return array
     */
    protected function buscarDadosCadastro(Aluno $aluno = null)
    {
        return $this->gerenciaAluno->carregarDependencias($aluno);
    }



    /**
     * Adiciona um novo registro.
     *
     * @param  SalvarAlunoRequest  $request
     * @param  Aluno  $aluno
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarAlunoRequest $request, Aluno $aluno)
    {
        $registro = DB::transaction(function () use ($request, $aluno) {
            $dados = $request->all();
            $dados['aluno_transportadora'] = 'F';

            return $this->gerenciaAluno->criar($aluno, $dados);
        });

        if (!$registro->id) {
            flash('Falha na gravação. Favor entrar em contato com o suporte técnico.')->error();

            return back()->withInput();
        }

        flash('Registro salvo com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'aluno', $registro);
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param  \App\Models\Aluno  $aluno
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterar(Aluno $aluno)
    {
        $dependencias = $this->buscarDadosCadastro($aluno);

        return view('aluno.alterar', compact('aluno', 'dependencias'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param  \App\Models\Aluno  $registro
     * @param  SalvarAlunoRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar(Aluno $registro, SalvarAlunoRequest $request)
    {
        $atualizado = DB::transaction(function () use ($registro, $request) {
            return $this->gerenciaAluno->alterar($registro->id, $request->all());
        });

        if (!$atualizado) {
            flash('Falha na atualização. Favor entrar em contato com o suporte técnico.')->error();

            return back()->withInput();
        }

        flash('Os dados do registro foram alterados com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'aluno', $registro);
    }

    /**
     * Exclui um registro.
     *
     * @param  \App\Models\Aluno  $registro
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function excluir(Aluno $registro)
    {
        $excluido = $this->gerenciaAluno->excluir($registro->id);
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
        $registros = Aluno::whereIn('id', $ids)->get();
        $excluido = $this->excluirVariosRegistros($registros);
        if (!$excluido) {
            return response()->json(['sucesso' => false]);
        }

        flash('Os registros foram excluídos com sucesso.')->success();

        return response()->json(['sucesso' => true]);
    }
}
