<?php

namespace App\Http\Controllers;

use App\Services\SessaoUsuario;
use Illuminate\Http\JsonResponse;
use App\Models\Unidade;
use App\Services\PerfilPrincipal;

class SelecionarUnidadeController extends Controller
{
    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    /**
     * @var PerfilPrincipal
     */
    private $perfilPrincipal;

    public function __construct(
        SessaoUsuario $sessaoUsuario,
        PerfilPrincipal $perfilPrincipal
    )
    {
        $this->sessaoUsuario = $sessaoUsuario;
        $this->perfilPrincipal = $perfilPrincipal;
    }

    /**
     * Exibe a tela para o usuário selecionar a unidade sendo gerenciada.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function index()
    {
        $usuarioLogado = auth()->user();
        $preSelecao = $this->sessaoUsuario->preSelecao($usuarioLogado);

        if (!$this->sessaoUsuario->unidade()) {
            $necessitaSelecao = $this->sessaoUsuario->necessitaSelecao($usuarioLogado);
            if (!$necessitaSelecao) {
                return $this->setarUnidadeAtiva($preSelecao['unidade_id'], $preSelecao['perfil_id']);
            }
        }

        $unidades = $usuarioLogado->unidades();

        return view('selecionar_unidade', compact('unidades', 'preSelecao'));
    }

    /**
     * Seta na sessão a unidade ativa sendo gerenciada.
     *
     * @param int $unidadeId
     * @param int $perfilId
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    private function setarUnidadeAtiva($unidadeId, $perfilId)
    {
        // Seta unidade na sessão
        $this->sessaoUsuario->atualizarDados('unidade', Unidade::findOrFail($unidadeId));

        // Sempre depois de setar a unidade ativa, vamos forçar o sistema a descobrir o perfil principal novamente
        $perfilUsuario = $this->perfilPrincipal->descobrirPerfilPrincipal($perfilId);
        $this->sessaoUsuario->atualizarDados('perfil_ativo', $perfilUsuario);

        return redirect()->route('dashboard');
    }

    /**
     * Seta na sessão a unidade ativa sendo gerenciada.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function selecionar()
    {
        return $this->setarUnidadeAtiva(request('unidade_id'), request('perfil_id'));
    }

    /**
     * Busca perfis em que o usuário está lotado da unidade informada
     *
     * @return JsonResponse
     */
    public function buscarPerfis()
    {
        $perfis = auth()->user()->perfisUnidade(request()->get('unidade_id'), true);
        
        return response()->json(['data' => $perfis]);
    }
}
