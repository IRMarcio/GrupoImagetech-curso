<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Perfil;
use App\Models\Usuario;
use App\Services\Usuario\GerenciaPerfilUsuario;
use Exception;
use DB;

class PerfilController extends Controller
{
    /**
     * @var GerenciaPerfilUsuario
     */
    private $gerenciaPerfilUsuario;

    public function __construct(
        GerenciaPerfilUsuario $gerenciaPerfilUsuario
    ) {
        $this->gerenciaPerfilUsuario = $gerenciaPerfilUsuario;
    }

    /**
     * Valida se é possível remover perfil do usuário
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validarRemocaoPerfil()
    {
        DB::beginTransaction();
        $retorno = true;

        try {
            $usuario = Usuario::withoutGlobalScopes()->findOrFail(Usuario::decodeSlug(request()->get('usuario_slug_id')));

            if (! (bool) $usuario->perfis()->detach(request()->get('perfil_id'))) {
                $retorno = false;
            }
        }
        catch (Exception $e) {
            $retorno = false;
        }

        DB::rollBack();

        return response()->json($retorno);
    }

    /**
     * Retorna os perfis atribuídos ao usuário informado.
     * 
     * @param Usuario $usuario
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function buscarPerfisAtribuidos()
    {
        $usuario = Usuario::withoutGlobalScopes()->findOrFail(Usuario::decodeSlug(request()->get('usuario_slug_id')));
        $usuario->load('perfis.unidade');

        return response()->json(['data' => $usuario->perfis]);
    }

    /**
     * Adiciona um novo perfil ao usuário
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function adicionar()
    {
        $usuario = Usuario::withoutGlobalScopes()->findOrFail(Usuario::decodeSlug(request()->get('usuario_slug_id')));

        $retorno = DB::transaction(function () use ($usuario) {
            return $this->gerenciaPerfilUsuario->adicionar($usuario, request()->get('perfil_id'));
        });

        return response()->json($retorno);
    }

    /**
     * Remover um perfil do usuário
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function remover()
    {
        $usuario = Usuario::withoutGlobalScopes()->findOrFail(Usuario::decodeSlug(request()->get('usuario_slug_id')));

        $retorno = DB::transaction(function () use ($usuario) {
            return $this->gerenciaPerfilUsuario->remover($usuario, request()->get('perfil_id'));
        });

        return response()->json($retorno);
    }
    
    /**
     * Ativar um perfil do usuário
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ativar()
    {
        $usuario = Usuario::withoutGlobalScopes()->findOrFail(Usuario::decodeSlug(request()->get('usuario_slug_id')));

        $retorno = DB::transaction(function () use ($usuario) {
            return $this->gerenciaPerfilUsuario->ativar($usuario, request()->get('perfil_id'));
        });

        return response()->json($retorno);
    }

    /**
     * Desativar um perfil do usuário
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function desativar(Perfil $perfil)
    {
        $usuario = Usuario::withoutGlobalScopes()->findOrFail(Usuario::decodeSlug(request()->get('usuario_slug_id')));
        
        $retorno = DB::transaction(function () use ($usuario) {
            return $this->gerenciaPerfilUsuario->desativar($usuario, request()->get('perfil_id'));
        });

        return response()->json($retorno);
    }

    /**
     * Definir um perfil do usuário como principal
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function definirComoPrincipal()
    {
        $usuario = Usuario::withoutGlobalScopes()->findOrFail(Usuario::decodeSlug(request()->get('usuario_slug_id')));

        $retorno = DB::transaction(function () use ($usuario) {
            return $this->gerenciaPerfilUsuario->definirComoPrincipal($usuario, request()->get('perfil_id'));
        });

        return response()->json($retorno);
    }
}
