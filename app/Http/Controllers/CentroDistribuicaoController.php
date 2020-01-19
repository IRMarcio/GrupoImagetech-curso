<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\SalvarCentroDistribuicaoRequest;
use App\Models\CatMat;
use App\Models\TabArmazem;
use App\Models\TabCentroDistribuicao;
use App\Models\TabEndLocacao;
use App\Models\Unidade;
use App\Relatorios\CentroDistribuicaoListagem;
use App\Services\GerenciaCentroDistribuicao;


use App\Services\MapsServiceSource;
use Hamcrest\Thingy;
use http\Url;
use Illuminate\Http\JsonResponse;
use App\Services\SessaoUsuario;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CentroDistribuicaoController extends Controller
{

    /**
     * @var SessaoUsuario
     */
    protected $sessaoUsuario;

    /**
     * @var CentroDistribuicaoListagem
     */
    private $listagem;

    /**
     * @var \App\Services\GerenciaCentroDistribuicao
     */
    private $gerenciarCentroDistribuicao;

    /**
     * @var TabCentroDistribuicao
     */
    private $distribuicao;

    /**
     * @var MapsServiceSource
     */
    private $mapsServiceSource;

    public function __construct(
        CentroDistribuicaoListagem $listagem,
        GerenciaCentroDistribuicao $gerenciarCentroDistribuicao,
        SessaoUsuario $sessaoUsuario,
        TabCentroDistribuicao $distribuicao,
        MapsServiceSource $mapsServiceSource
    ) {
        parent::__construct();

        $this->listagem = $listagem;
        $this->gerenciarCentroDistribuicao = $gerenciarCentroDistribuicao;
        $this->sessaoUsuario = $sessaoUsuario;
        $this->distribuicao = $distribuicao;
        $this->mapsServiceSource = $mapsServiceSource;
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
        $unidades = collect();
        if (!($usuarioLogado->super_admin)) {
            $dados = $this->sessaoUsuario->centroDistribuicao();

            return redirect()->route('centro_distribuicao.alterar', $dados);
        }
        $filtros = request()->all();
        if (isset($filtros['acao']) && $filtros['acao'] == 'imprimir') {
            return $this->listagem->exportar($filtros);
        }
        $dados = $this->listagem->gerar($filtros);

        return view('centro_distribuicao.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @param  TabCentroDistribuicao|null  $centro_distribuicao
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \ReflectionException
     */
    public function adicionar(TabCentroDistribuicao $centro_distribuicao = null)
    {
        //Gera Mapa de Cadastro de Centro de Distribuição para localização da latitude e longitude;
        $map = $this->mapsServiceSource->call('getLatLng');

        if (is_null($centro_distribuicao)) {
            // Gera um registro temporário para ser usado
            $centro_distribuicao = TabCentroDistribuicao::gerarTemporario();
        }
        $dependencias = $this->buscarDadosCadastro($centro_distribuicao);

        return view('centro_distribuicao.adicionar', compact('centro_distribuicao', 'dependencias', 'unidades', 'map'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @param  TabArmazem|null  $centro_distribuicao
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \ReflectionException
     */
    public function adicionarArmazens($id, TabArmazem $centro_distribuicao = null)
    {

        if (is_null($centro_distribuicao)) {
            // Gera um registro temporário para ser usado
            $centro_distribuicao = TabCentroDistribuicao::gerarTemporario();
        }
        $dependencias = $this->buscarDadosCadastroArmazem($centro_distribuicao);

        return view('centro_distribuicao.armazem.adicionar', compact('centro_distribuicao', 'dependencias', 'id'));
    }

    /**
     * Busca os dados utilizados para o cadastro/alteração de centro_distribuicao.
     *
     * @param  TabCentroDistribuicao|null  $centro_distribuicao
     *
     * @return array
     */
    protected function buscarDadosCadastro($centro_distribuicao = null)
    {
        return $this->gerenciarCentroDistribuicao->carregarDependencias($centro_distribuicao);
    }

    /**
     * Busca os dados utilizados para o cadastro/alteração de centro_distribuicao.
     *
     * @param  TabCentroDistribuicao|null  $centro_distribuicao
     *
     * @return array
     */
    protected function buscarDadosCadastroArmazem($centro_distribuicao = null)
    {
        return $this->gerenciarCentroDistribuicao->carregarDependenciasArmazem($centro_distribuicao);
    }

    /**
     * Adiciona um novo registro.
     *
     * @param  SalvarCentroDistribuicaoRequest  $request
     * @param  TabCentroDistribuicao  $centro_distribuicao
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarCentroDistribuicaoRequest $request, TabCentroDistribuicao $centro_distribuicao)
    {

        $registro = DB::transaction(function () use ($request, $centro_distribuicao) {
            $retorno = $this->gerenciarCentroDistribuicao->criar($centro_distribuicao, $request->all());

            return $retorno->endereco()->create($request->all());
        });
        if (!$registro->id) {
            flash('Falha na gravação. Favor entrar em contato com o suporte técnico.')->error();

            return back()->withInput();
        }
        flash('Registro salvo com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'centro_distribuicao', $registro);
    }

    /**
     * Adiciona um novo registro via Seeder.
     *
     * @param  SalvarCentroDistribuicaoRequest  $request
     * @param  TabCentroDistribuicao  $centro_distribuicao
     */
    public function addSeederCentro($request, TabCentroDistribuicao $centro_distribuicao)
    {
        DB::transaction(function () use ($request, $centro_distribuicao) {
            $retorno = $this->gerenciarCentroDistribuicao->criar($centro_distribuicao, $request);

            return $retorno->endereco()->create($request);
        });
    }

    /**
     * Adiciona um novo registro.
     *
     * @param  SalvarCentroDistribuicaoRequest  $request
     * @param  TabCentroDistribuicao  $centro_distribuicao
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvarArmazens(SalvarCentroDistribuicaoRequest $request)
    {
        $saveDataRelation = $this->distribuicao->findOrFail(request()->idCd);
        $registro = $saveDataRelation->armazem()->create(request()->all());
        $this->gerenciarCentroDistribuicao->getEndLocacao($registro);
        $registro->endereco()->create(request()->all());
        if (!$registro->id) {
            flash('Falha na gravação. Favor entrar em contato com o suporte técnico.')->error();

            return back()->withInput();
        }
        flash('Registro salvo com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'centro_distribuicao', $registro);
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param  \App\Models\TabCentroDistribuicao  $centro_distribuicao
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterar(TabCentroDistribuicao $centro_distribuicao)
    {


        $dependencias = $this->buscarDadosCadastro($centro_distribuicao);

        //Gera Mapa de Cadastro de Centro de Distribuição para localização da latitude e longitude;

        $map = $this->mapsServiceSource->call('markers_single', $centro_distribuicao->endereco->geoLocalizacao);

        $endereco_fisico = $centro_distribuicao
            ->endAlocacao
            ->load(
                [
                    'carga.movimento.catmat',
                    'carga.movimento.estocagem.relacao.produto'
                ])
            ->groupBy(['area', 'rua', 'modulo', 'nivel'])->sortKeys();

        return view('centro_distribuicao.alterar', compact('centro_distribuicao', 'dependencias', 'endereco_fisico', 'map'));
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param  TabEndLocacao  $endereco
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterarEndereco(TabEndLocacao $endereco)
    {

        $enderecos = TabCentroDistribuicao::find($endereco->centro_distribuicao_id);
        $enderecos = $enderecos->endAlocacao;


        $encode = json_encode([
            'area'   => $endereco->area,
            'rua'    => $endereco->rua,
            'modulo' => $endereco->modulo,
            'nivel'  => $endereco->nivel,
            'vao'    => $endereco->vao,
        ], true);

        QrCode::format('png')
              ->generate($encode, public_path('img/endereco.png'));

        $endereco->load([
            'carga.movimento.catmat',
            'carga.movimento.estocagem.relacao'
        ]);
        $enderecos->load([
            'carga.movimento.catmat',
            'carga.movimento.estocagem.relacao'
        ]);
        return view('centro_distribuicao.alterar_endereco', compact('endereco', 'enderecos', 'encode'));
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param  \App\Models\TabCentroDistribuicao  $centro_distribuicao
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterarEnderecoPost()
    {


        $url = request()->input('url');

        $dados = request()->all();
        $atualizado = DB::transaction(function () use ($dados) {
            return $this->gerenciarCentroDistribuicao->updateEndereco($dados);
        });
        if (!$atualizado) {
            flash('Falha na atualização. Favor entrar em contato com o suporte técnico.')->error();

            return back()->withInput();
        }
        flash('Os dados do registro foram alterados com sucesso.')->success();

        return redirect($url);
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param  \App\Models\TabCentroDistribuicao  $centro_distribuicao
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleteEnderecoPost()
    {
        $url = request()->input('url');

        $deletado = DB::transaction(function () {
            return $this->gerenciarCentroDistribuicao->deleteEndereco();
        });

        if (!$deletado) {
            flash('Falha na Remoção do Endereço. Favor entrar em contato com o suporte técnico.')->error();

            return back()->withInput();
        }

        flash('O Endereço foi deletado com sucesso.')->success();

        return redirect($url);
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param  \App\Models\TabCentroDistribuicao  $centro_distribuicao
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function visualizarEstoqueCd()
    {

        $centro_distribuicao = $this->sessaoUsuario->centroDistribuicao();

        if (!$centro_distribuicao) {
            flash('Não Foi Selecionado Centro de Distribuição para este Perfil.')->error();

            return redirect()->back();
        }

        $dependencias = $this->buscarDadosCadastro($centro_distribuicao);
        $endereco_fisico = $centro_distribuicao
            ->endAlocacao
            ->load(
                [
                    'carga.movimento.catmat',
                    'carga.movimento.estocagem.relacao.produto'
                ]
            )->groupBy(['area', 'rua', 'modulo', 'nivel'])->sortKeys();

        return view('centro_distribuicao.endereco.carga', compact('centro_distribuicao', 'dependencias', 'endereco_fisico'));
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param  \App\Models\TabCentroDistribuicao  $centro_distribuicao
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterarArmazens($id, $idCd)
    {
        $centro_distribuicao = $this->distribuicao->find($idCd);
        $centro_distribuicao = $centro_distribuicao->armazem->find($id);
        $dependencias = $this->buscarDadosCadastroArmazem($centro_distribuicao);

        return view('centro_distribuicao.armazem.alterar', compact('centro_distribuicao', 'dependencias'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param  \App\Models\TabCentroDistribuicao  $registro
     * @param  SalvarCentroDistribuicaoRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar(TabCentroDistribuicao $registro, SalvarCentroDistribuicaoRequest $request)
    {
        $dados = $request->all();

        $atualizado = DB::transaction(function () use ($dados, $registro) {
            return $this->gerenciarCentroDistribuicao->alterar($registro->id, $dados);
        });
        if (!$atualizado) {
            flash('Falha na atualização. Favor entrar em contato com o suporte técnico.')->error();

            return back()->withInput();
        }
        flash('Os dados do registro foram alterados com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'centro_distribuicao', $registro);
    }

    /**
     * Altera os dados de um registro.
     *
     * @param  \App\Models\TabCentroDistribuicao  $registro
     * @param  SalvarCentroDistribuicaoRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizarArmazens($id, $idCd, SalvarCentroDistribuicaoRequest $request)
    {
        $dados = $request->all();
        $atualizado = DB::transaction(function () use ($id, $idCd, $dados) {
            return $this->gerenciarCentroDistribuicao->alterarArmazem($id, $idCd, $dados);
        });
        if (!$atualizado) {
            flash('Falha na atualização. Favor entrar em contato com o suporte técnico.')->error();

            return back()->withInput();
        }
        flash('Os dados do registro foram alterados com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'centro_distribuicao', $atualizado);
    }

    /**
     * Exclui um registro.
     *
     * @param  \App\Models\TabCentroDistribuicao  $registro
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function excluir(TabCentroDistribuicao $registro)
    {
        $excluido = $this->gerenciarCentroDistribuicao->excluir($registro->id);

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
        $registros = TabCentroDistribuicao::whereIn('id', $ids)->get();
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
        $centro_distribuicao = TabCentroDistribuicao::findOrFail(request()->centro_distribuicao_id);

        return response()->json(['data' => $centro_distribuicao->armazem]);
    }

    /**
     * Carrega as seções da unidade informada
     *
     * @return JsonResponse
     */
    public function carregarEnderecos()
    {
        $unidade = Unidade::find(request()->unidade_id);
        $retorno = isset($unidade->centroAtivo) ? $unidade->centroAtivo->centro->endAlocacao : [];

        return response()->json(['data' => $retorno]);
    }

    public function carregarProdutos()
    {
        $campo = request('campo');
        $id = request('id');
        if ($campo === 'centro_distribuicao_id') {
            $centroAmazem = TabCentroDistribuicao::with('estoqueInventario.catmat')
                                                 ->whereHas('estoqueInventario.catmat', function ($catmat) {
                                                     $catmat->where('quantidade', '!=', 0);
                                                 })->find($id);
        }

        $arrayRetorno = [];
        $centroAmazem->estoqueInventario->map(function ($item) use (&$arrayRetorno) {
            if (!isset($arrayRetorno[$item->catmat->id])) {
                $arrayRetorno[$item->catmat->id] = $item;
            } else {
                $arrayRetorno[$item->catmat->id]->quantidade += $item->quantidade;
            }
        });

        return response()->json($arrayRetorno);
    }

    public function carregarTodosProdutos()
    {
        $Retorno =  CatMat::all();
        return response()->json($Retorno);
    }
}
