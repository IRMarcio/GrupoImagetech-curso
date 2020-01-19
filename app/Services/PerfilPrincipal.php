<?php

namespace App\Services;


use Exception;

class PerfilPrincipal
{
    /**
     * Retorna os dados do perfil principal.
     *
     * @param int|null $perfilId perfil que será definido como principal.
     *
     * @return mixed
     * @throws Exception
     */
    public function descobrirPerfilPrincipal($perfilId = null)
    {
        $usuario = auth()->user();

        if (is_null($perfilId)) {
            $perfilPrincipal = $usuario->retornarPerfilPrincipal(true);
        } else {
            $perfilPrincipal = collect($usuario->perfis)->where('id', $perfilId)->first();
        }

        // Não achou nenhum perfil para o usuário, de repente as funções dele estão desativas
        if (is_null($perfilPrincipal) && $usuario->super_admin === false) {
            return abort(404);
        }

        return $perfilPrincipal;
    }
}
