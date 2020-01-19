<?php

namespace App\Http\Controllers\Relatorios;

use App\Http\Controllers\Controller;
use App\Models\TabEndereco;
use App\Models\TabEndLocacao;
use App\Relatorios\EstoqueListagemProdutoEndereco;
use App\Services\SessaoUsuario;
use DB;
use App\Models\Unidade;
use App\Models\Secao;


class EstoqueController extends Controller
{

    /**
     * @var EstoqueListagem
     */
    private $listagem;

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;
    /**
     * @var Unidade
     */
    private $unidade;
    /**
     * @var EstoqueListagemProdutoEndereco
     */
    private $listagemProdutoEndereco;

    public function __construct(Unidade $unidade, EstoqueListagemProdutoEndereco $listagemProdutoEndereco, SessaoUsuario $sessaoUsuario)
    {

        $this->sessaoUsuario = $sessaoUsuario;
        $this->unidade = $unidade;
        $this->listagemProdutoEndereco = $listagemProdutoEndereco;
    }

    /**
     * Exibe a lista de estoque.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $filtros = request()->all();
        $enderecos = collect();

        $unidades = Unidade::orderBy('descricao')->get();


        if (!empty($filtros['unidade_id'])) {
            $enderecos = TabEndLocacao::whereCentroDistribuicaoId($filtros['unidade_id'])->get();
        }

        $usuarioLogado = auth()->user();

        if (!$usuarioLogado->super_admin) {
            $unidades = collect([0 => $this->sessaoUsuario->unidade()]);
            $filtros['unidade_id'] = $this->sessaoUsuario->unidade()->id;
            $enderecos = TabEndLocacao::whereCentroDistribuicaoId($filtros['unidade_id'])->get();
        }

        if (isset($filtros['acao']) && $filtros['acao'] == 'imprimir') {
            return $this->listagem->exportar($filtros);
        }

        $dados = $this->listagem->gerar($filtros, true, []);

        return view('relatorios.estoque.index', compact('dados', 'filtros', 'unidades', 'usuarioLogado', 'enderecos'));
    }

    /**
     * Exibe a lista de estoque.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listEndEstoque()
    {

        $filtros = request()->all();

        $unidades = Unidade::orderBy('descricao')->get();
        $secoes = collect();


        if (!empty($filtros['unidade_id'])) {
            $secoes = Secao::where('unidade_id', $filtros['unidade_id'])->orderBy('descricao')->get();
        }

        $usuarioLogado = auth()->user();

        if (!$usuarioLogado->super_admin && !$usuarioLogado->gestor) {
            $filtros['unidade_id'] = $this->sessaoUsuario->unidade()->id;
            $secoes = $this->sessaoUsuario->unidade()->secoes;
        }

        if (isset($filtros['acao']) && $filtros['acao'] == 'imprimir') {
            return $this->listagem->exportar($filtros);
        }

        $dados = $this->listagemProdutoEndereco->gerar($filtros, true, []);


        return view('relatorios.listagem_endereco.index', compact('dados', 'filtros', 'unidades', 'usuarioLogado', 'secoes'));
    }
}
