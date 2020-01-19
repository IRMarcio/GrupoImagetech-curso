<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarPerfilRequest;
use App\Relatorios\PerfilListagem;
use DB;
use App\Models\Perfil;
use App\Models\Unidade;
use App\Models\Usuario;
use App\Services\GerenciaPermissoes;
use App\Services\SessaoUsuario;

class PerfilController extends Controller
{

    /**
     * @var PerfilListagem
     */
    private $listagem;

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    /**
     * @var GerenciaPermissoes
     */
    private $gerenciaPermissoes;

    public function __construct(
        PerfilListagem $listagem, 
        GerenciaPermissoes $gerenciaPermissoes,
        SessaoUsuario $sessaoUsuario
    )
    {
        parent::__construct();

        $this->listagem = $listagem;
        $this->gerenciaPermissoes = $gerenciaPermissoes;
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
        
        // Se usuário não for gestor nem super admin, mostrar somente funções da unidade que ele está logado
        $usuarioLogado = auth()->user();
        if (!( $usuarioLogado->super_admin)) {
            $filtros['unidade_id'] = $this->sessaoUsuario->unidade()->id;
        }

        $with = ['unidade'];
        if (isset($filtros['acao']) && $filtros['acao'] == 'imprimir') {
            return $this->listagem->exportar($filtros, $with);
        }

        $dados = $this->listagem->gerar($filtros, isset($filtros['paginar']) ? $filtros['paginar'] : true, $with);
        if (request()->wantsJson()) {
            return response()->json(['data' => $dados]);
        }

        $dependencias = [];
        $dependencias['unidades'] = Unidade::where('ativo', true)->orderBy('descricao', 'ASC')->get();

        return view('perfil.index', compact('dados', 'filtros', 'dependencias'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        $dependencias = $this->buscarDadosCadastro();

        return view('perfil.adicionar', compact('dependencias'));
    }

    /**
     * Retorna os dados utilizados no cadastro de funções.
     *
     * @return array
     */
    private function buscarDadosCadastro()
    {
        $usuarioLogado = auth()->user();

        // Se usuário for super_admin vai dar possibilidade de selecionar qualquer unidade {}
        // Caso contrário usuário poderá selecionar somente unidades das quais faz parte
        if ( $usuarioLogado->super_admin) {
            $unidades = Unidade::where('ativo', true)->orderBy('descricao', 'ASC')->get();
        } else {
            $unidadePreDefinida = $this->sessaoUsuario->unidade();
        }

        return compact('unidades', 'unidadePreDefinida');
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarPerfilRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarPerfilRequest $request)
    {
        $registro = Perfil::create($request->all());
        if (!$registro->id) {
            return back()->withInput();
        }

        $this->gerenciaPermissoes->salvar($registro->id, $request->get('rotas'));
        flash('Registro salvo com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'perfil', $registro);
    }


    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param Perfil $perfil
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterar(Perfil $perfil)
    {
        $dependencias = $this->buscarDadosCadastro();

        $filtros = ['perfil_id' => $perfil->id];
        $viewRotas = $this->gerenciaPermissoes->carregarViewGerenciamento($filtros);

        return view('perfil.alterar', compact('perfil', 'viewRotas', 'dependencias'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param Perfil $registro
     * @param SalvarPerfilRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar(Perfil $registro, SalvarPerfilRequest $request)
    {
        $atualizado = $registro->update($request->all());
        if (!$atualizado) {
            return back()->withInput();
        }

        $this->gerenciaPermissoes->salvar($registro->id, $request->get('rotas'));
        flash('Os dados do registro foram alterados com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'perfil', $registro);
    }

    /**
     * Exclui um registro.
     *
     * @param Perfil $registro
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function excluir(Perfil $registro)
    {
        $excluido = $registro->delete();
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
        $registros = Perfil::whereIn('id', $ids)->get();
        $excluido = $this->excluirVariosRegistros($registros);
        if (!$excluido) {
            return response()->json(['sucesso' => false]);
        }

        flash('Os registros foram excluídos com sucesso.')->success();

        return response()->json(['sucesso' => true]);
    }
}
