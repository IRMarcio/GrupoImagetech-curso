<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalvarEnderecamentoRequest;
use App\Models\Enderecamento;
use App\Models\Unidade;
use App\Models\Secao;
use App\Relatorios\EnderecamentoListagem;
use App\Repositories\TipoProdutoRepository;
use App\Repositories\EnderecamentoRepository;
use App\Services\SessaoUsuario;

class EnderecamentoController extends Controller
{

    /**
     * @var EnderecamentoListagem
     */
    private $listagem;

    /**
     * @var EnderecamentoRepository
     */
    private $repository;

    /**
     * @var TipoProdutoRepository
     */
    private $tipoProdutoRepository;

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    public function __construct(EnderecamentoListagem $listagem, EnderecamentoRepository $repository, TipoProdutoRepository $tipoProdutoRepository, SessaoUsuario $sessaoUsuario)
    {
        parent::__construct();

        $this->listagem = $listagem;
        $this->repository = $repository;
        $this->tipoProdutoRepository = $tipoProdutoRepository;
        $this->sessaoUsuario = $sessaoUsuario;
    }

    /**
     * Lista todos os registros do sistema.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $with = ['tipoProduto'];

        $filtros = request()->all();
        $unidades = Unidade::orderBy('descricao')->get();
        $secoes = collect();

        if (!empty($filtros['unidade_id'])) {
            $secoes = Secao::where('unidade_id', $filtros['unidade_id'])->orderBy('descricao')->get();
        }

        $usuarioLogado = auth()->user();
        if ( ! $usuarioLogado->super_admin && ! $usuarioLogado->gestor) {
            $filtros['unidade_id'] = $this->sessaoUsuario->unidade()->id;
            $secoes = $this->sessaoUsuario->unidade()->secoes;
        }

        if (isset($filtros['acao']) && $filtros['acao'] == 'imprimir') {
            return $this->listagem->exportar($filtros, $with);
        }
        
        $dados = $this->listagem->gerar($filtros, isset($filtros['paginar']) ? $filtros['paginar'] : true, $with);
        if (request()->wantsJson()) {
            return response()->json(['data' => $dados]);
        }

        $tiposProdutos = $this->tipoProdutoRepository->buscarTodosOrdenados('descricao');

        return view('enderecamento.index', compact('dados', 'filtros', 'tiposProdutos', 'secoes', 'unidades', 'usuarioLogado'));
    }

    /**
     * Retorna os dados utilizados no cadastro.
     * 
     * @param Enderecamento $registro
     *
     * @return array
     */
    private function buscarDadosCadastro($registro = null)
    {
        $usuarioLogado = auth()->user();
        // Usuário não é super admin nem gestor
        if ( ! $usuarioLogado->super_admin && ! $usuarioLogado->gestor) {
            // Seções virão carregadas e unidade não vai aparecer
            $secoes = $this->sessaoUsuario->unidade()->secoes;
        } else {
            // Unidade vai aparecer
            $unidades = Unidade::where('ativo', true)->orderBy('descricao', 'ASC')->get();
            
            // Se registro estiver setado, carrega as seções
            if (isset($registro)) {
                $secoes = $registro->secao->unidade->secoes;
            }
        }

        return compact('secoes', 'unidades');
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        $tiposProdutos = $this->tipoProdutoRepository->buscarTodosOrdenados('descricao');
        $dependencias = $this->buscarDadosCadastro();

        return view('enderecamento.adicionar', compact('tiposProdutos', 'dependencias'));
    }

    /**
     * Adiciona um novo registro.
     *
     * @param \Modules\Nucleo\Http\Requests\SalvarEnderecamentoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarEnderecamentoRequest $request)
    {
        $registro = $this->repository->create($request->all());
        if (!$registro->id) {
            return back()->withInput();
        }

        flash('Registro salvo com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'enderecamento', $registro);
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param Enderecamento $enderecamento
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterar(Enderecamento $enderecamento)
    {
        $tiposProdutos = $this->tipoProdutoRepository->buscarTodosOrdenados('descricao');
        $dependencias = $this->buscarDadosCadastro($enderecamento);

        return view('enderecamento.alterar', compact('enderecamento', 'tiposProdutos', 'dependencias'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param Enderecamento $registro
     * @param \Modules\Nucleo\Http\Requests\SalvarEnderecamentoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar(Enderecamento $registro, SalvarEnderecamentoRequest $request)
    {
        $atualizado = $this->repository->update($registro, $request->all());
        if (!$atualizado) {
            return back()->withInput();
        }

        flash('Os dados do registro foram alterados com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'enderecamento', $registro);
    }

    /**
     * Exclui um registro.
     *
     * @param Enderecamento $registro
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function excluir(Enderecamento $registro)
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
}
