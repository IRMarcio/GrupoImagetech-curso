<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Hash;
use Exception;
use App\Models\Usuario;
use App\Models\SituacaoUsuario;
use App\Relatorios\UsuarioListagem;
use App\Services\PerfilPrincipal;
use App\Services\GerenciaSession;
use App\Services\SessaoUsuario;
use App\Services\Mascarado;
use App\Services\ValidaSenhaAlterada;
use App\Services\Usuario\AlterarSenha;
use App\Services\Usuario\GerenciaPerfilUsuario;
use App\Services\Usuario\GerenciaUsuario;
use App\Repositories\SituacaoUsuarioRepository;
use App\Http\Requests\AlterarPerfilRequest;
use App\Http\Requests\AlterarSenhaRequest;
use App\Http\Requests\SalvarUsuarioRequest;

class UsuarioController extends Controller
{

    /**
     * @var PerfilPrincipal
     */
    private $perfilPrincipal;

    /**
     * @var UsuarioListagem
     */
    private $listagem;

    /**
     * @var GerenciaUsuario
     */
    private $gerenciaUsuario;

    /**
     * @var ValidaSenhaAlterada
     */
    private $validaSenhaAlterada;

    /**
     * @var SituacaoUsuarioRepository
     */
    private $situacaoUsuarioRepository;

    /**
     * @var AlterarSenha
     */
    private $alterarSenha;

    /**
     * @var GerenciaSession
     */
    private $gerenciaSession;

    /**
     * @var GerenciaPerfilUsuario
     */
    private $gerenciaPerfilUsuario;
    
    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    public function __construct(
        UsuarioListagem $listagem,
        PerfilPrincipal $perfilPrincipal,
        GerenciaUsuario $gerenciaUsuario,
        ValidaSenhaAlterada $validaSenhaAlterada,
        SituacaoUsuarioRepository $situacaoUsuarioRepository,
        AlterarSenha $alterarSenha,
        GerenciaSession $gerenciaSession,
        GerenciaPerfilUsuario $gerenciaPerfilUsuario,
        SessaoUsuario $sessaoUsuario
    ) {
        parent::__construct();

        $this->perfilPrincipal = $perfilPrincipal;
        $this->listagem = $listagem;
        $this->gerenciaUsuario = $gerenciaUsuario;
        $this->validaSenhaAlterada = $validaSenhaAlterada;
        $this->situacaoUsuarioRepository = $situacaoUsuarioRepository;
        $this->alterarSenha = $alterarSenha;
        $this->gerenciaSession = $gerenciaSession;
        $this->gerenciaPerfilUsuario = $gerenciaPerfilUsuario;
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
        
        // Se usuário logado não for gestor nem super admin, mostra somente usuários da própria unidade
        $usuarioLogado = auth()->user();
        if (! ($usuarioLogado->super_admin) ) {
            $filtros['unidade_id'] = $this->sessaoUsuario->unidade()->id;
        }

        if (isset($filtros['acao']) && $filtros['acao'] == 'imprimir') {
            return $this->listagem->exportar($filtros);
        }

        $dados = $this->listagem->gerar($filtros, true, ['situacoes']);
        if (request()->wantsJson()) {
            return response()->json(['data' => $dados]);
        }

        $situacoes = $this->situacaoUsuarioRepository->buscarTodosOrdenados();
        $situacaoInativo = $this->situacaoUsuarioRepository->buscarPorSlug('inativo');

        return view('usuario.index', compact('dados', 'filtros', 'situacaoInativo', 'situacoes'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @param null|Usuario $usuario
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar(Usuario $usuario = null)
    {
        if (is_null($usuario)) {
            // Gera um registro temporário para ser usado
            $usuario = Usuario::gerarTemporario();
        }

        $usuario->load('situacoes');

        $usuarioLogado = auth()->user();
        $dependencias = $this->gerenciaUsuario->dependencias($usuarioLogado);

        return view('usuario.adicionar', compact('dependencias', 'usuario', 'id'));
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarUsuarioRequest $request
     * @param Usuario $usuario
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarUsuarioRequest $request, Usuario $usuario)
    {

        $registro = DB::transaction(function () use ($request, $usuario) {
            return $this->gerenciaUsuario->criar($usuario, $request->all());
        });

        if (!$registro->id) {
            flash('Falha na gravação. Favor entrar em contato com o suporte técnico.')->error();

            return back()->withInput();
        }

        flash('Registro salvo com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'usuario', $registro);
    }

    /**
     * Exibe a tela para alterar dados do registro.
     *
     * @param Usuario $usuario
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterar(Usuario $usuario)
    {
        $usuario->load(['situacoes', 'perfis.unidade']);
        $usuarioLogado = auth()->user();
        $dependencias = $this->gerenciaUsuario->dependencias($usuarioLogado);

        return view('usuario.alterar', compact('usuario', 'dependencias'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param Usuario $registro
     *
     * @param SalvarUsuarioRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar(Usuario $registro, SalvarUsuarioRequest $request)
    {
        $dados = $request->all();
        $registro = $this->gerenciaUsuario->alterar($registro->id, $dados);
        if (!$registro) {
            return back()->withInput();
        }

        flash('Os dados do registro foram alterados com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'usuario', $registro);
    }

    /**
     * Exclui um registro.
     *
     * @param Usuario $registro
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function excluir(Usuario $registro)
    {
        $excluido = DB::transaction(function () use ($registro) {
            return $this->gerenciaUsuario->excluir($registro->id);
        });

        if (!$excluido) {
            return back()->withInput();
        }

        flash('O registro foi excluído com sucesso.')->success();

        return redirect()->back();
    }

    /**
     * Exibe a tela para o usuário alterar seu perfil.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterarPerfil()
    {
        $perfis = auth()->user()->perfisUnidade($this->sessaoUsuario->unidade() ? $this->sessaoUsuario->unidade()->id : null, true);

        return view('usuario.alterar_perfil', compact('perfis'));
    }

    /**
     * Atualiza o perfil do usuário logado.
     *
     * @param AlterarPerfilRequest $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function salvarPerfil(AlterarPerfilRequest $request)
    {

        $perfil = $this->perfilPrincipal->descobrirPerfilPrincipal($request->get('perfil_id'));
        $this->sessaoUsuario->atualizarDados('perfil_ativo', $perfil);
        flash('Perfil alterado com sucesso.')->success();

        return back();
    }

    /**
     * Exibe a tela para o usuário alterar sua senha.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterarSenha()
    {
        return view('usuario.alterar_senha');
    }

    /**
     * Atualiza a senha do usuário logado.
     *
     * @param AlterarSenhaRequest $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function salvarSenha(AlterarSenhaRequest $request)
    {
        try {
            $dados = $request->all();
            $usuario = auth()->user();

            $valido = $this->alterarSenha->validar($usuario, $dados);
            if (!$valido) {
                return back();
            }

            DB::transaction(function () use ($usuario, $dados) {
                $this->alterarSenha->alterar($usuario, $dados['nova_senha']);
            });

            flash('A sua senha foi alterada com sucesso.')->success();
        }
        catch (Exception $e) {
            Log::error($e);
            flash('Houve um erro ao alterar a sua senha, contate o suporte técnico.')->error();
        }

        return back();
    }

    /**
     * Verifica se para o CPF informado já existe um usuário.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validarCpf()
    {
        $usuario = Usuario::where('cpf', Mascarado::removerMascara(request('cpf')))->first();
        if (!isset($usuario)) {
            return response()->json(false);
        }

        return response()->json(['usuario' => $usuario]);
    }

    /**
     * Invalida a senha do usuário marcando para que no próximo login ele seja obrigado a gerar uma nova.
     *
     * @param Usuario $usuario
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function invalidarSenha(Usuario $usuario)
    {
        try {
            DB::transaction(function () use ($usuario) {
                $usuario->adicionarSituacao('senha_invalidada');
            });
            flash("A senha do usuário foi invalidada com sucesso. O usuário deverá gerar uma nova senha em seu próximo login.")->success();
        }
        catch (Exception $e) {
            Log::error($e);
            flash("Houve um erro ao invalidar a senha do usuário, contate o suporte técnico.")->error();
        }

        return back();
    }

    /**
     * Invalida a senha do(s) usuário(s) marcando(s) para que no próximo login ele(s) seja(m) obrigado(s) a gerar uma
     * nova.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function invalidarSenhaVarios()
    {
        try {
            $ids = request('ids');
            DB::transaction(function () use ($ids) {
                foreach ($ids as $id) {
                    $usuario = Usuario::find($id);
                    $usuario->adicionarSituacao('senha_invalidada');
                }
            });

            if (count($ids) > 1) {
                flash("As senhas dos usuários foram invalidadas com sucesso. Os usuários deverão gerar uma nova senha em seu próximo login.")->success();
            } else {
                flash("A senha do usuário foi invalidada com sucesso. O usuário deverá gerar uma nova senha em seu próximo login.")->success();
            }

            return response()->json(['sucesso' => true]);
        }
        catch (Exception $e) {
            Log::error($e);

            return response()->json(['sucesso' => false]);
        }
    }

    /**
     * Remove uma situação de um usuário.
     *
     * @param Usuario $usuario
     * @param SituacaoUsuario $situacao
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removerSituacao(Usuario $usuario, SituacaoUsuario $situacao)
    {
        try {
            $retorno = DB::transaction(function () use ($usuario, $situacao) {
                return $usuario->removerSituacao($situacao->slug);
            });

            if (request()->wantsJson()) {
                return response()->json(['data' => $retorno ? $situacao->id : false]);
            }

            flash("A situação <strong>$situacao->descricao</strong> foi removida com sucesso do usuário.")->success();
        }
        catch (Exception $e) {
            Log::error($e);
            if (request()->wantsJson()) {
                return response()->json(['data' => ['errros' => $e->getMessage()]]);
            }

            flash("Houve um erro ao remover a situação $situacao->descricao do usuário, contate o suporte técnico.")->error();
        }

        return back();
    }

    /**
     * Adiciona uma situação em um usuário.
     *
     * @param Usuario $usuario
     * @param SituacaoUsuario $situacao
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function adicionarSituacao(Usuario $usuario, SituacaoUsuario $situacao)
    {
        try {
            DB::transaction(function () use ($usuario, $situacao) {
                $usuario->adicionarSituacao($situacao->slug);
            });

            flash("A situação <strong>$situacao->descricao</strong> foi adicionada com sucesso no usuário.")->success();
        }
        catch (Exception $e) {
            Log::error($e);
            flash("Houve um erro ao adicionar a situação $situacao->descricao no usuário, contate o suporte técnico.")->error();
        }

        return back();
    }

    /**
     * Ativa um usuário inativo no sistema.
     *
     * @param Usuario $usuario
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ativar(Usuario $usuario)
    {
        DB::transaction(function () use ($usuario) {
            $usuario->removerSituacao('inativo');
        });

        flash("O usuário foi <strong>ativado</strong> com sucesso no sistema.")->success();

        return back();
    }

    /**
     * Desativa um usuário ativo no sistema.
     *
     * @param Usuario $usuario
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function desativar(Usuario $usuario)
    {
        DB::transaction(function () use ($usuario) {
            $usuario->adicionarSituacao('inativo');
        });

        flash("O usuário foi <strong>desativado</strong> com sucesso no sistema.")->success();

        return back();
    }

    /**
     * Desbloqueia um usuário que foi bloqueado por muitas tentativas de login erradas.
     *
     * @param Usuario $usuario
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function desbloquearTentativas(Usuario $usuario)
    {
        DB::transaction(function () use ($usuario) {
            $usuario->removerSituacao('bloqueado_tentativa');
        });

        flash("O usuário foi <strong>desbloqueado</strong> com sucesso no sistema.")->success();

        return back();
    }

    /**
     * Bloqueia sessão do usuário, solicitação realizada pelo mesmo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bloquearTela()
    {
        $this->gerenciaSession->bloquearTela(auth()->user()->id);

        return response()->json(true);
    }
}
