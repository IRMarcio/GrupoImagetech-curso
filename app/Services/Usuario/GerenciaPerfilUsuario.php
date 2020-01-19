<?php

namespace App\Services\Usuario;

use App\Models\Perfil;
use App\Models\Usuario;

class GerenciaPerfilUsuario
{
    /**
     * Adição de um perfil ao usuário
     *
     * @param Usuario $usuario
     * @param int $perfilId
     *
     * @return bool
     */
    public function adicionar(Usuario $usuario, $perfilId)
    {
        $perfil = Perfil::find($perfilId);

        // Verifica se já existe perfil principal para a unidade do perfil informado
        $perfilPrincipalAtual = $usuario->perfis->filter(function($perfilTemp) use ($perfil) {
            return $perfilTemp->unidade_id === $perfil->unidade_id && $perfilTemp->pivot->principal;
        })->first();

        // Atribui o perfil
        $usuario->perfis()->syncWithoutDetaching([
            $perfilId => ['principal' => $perfilPrincipalAtual ? 0 : 1, 'ativo' => 1]
        ]);
        
        return true;
    }

    /**
     * Remove um perfil do usuário
     *
     * @param Usuario $usuario
     * @param int $perfilId
     *
     * @return bool
     */
    public function remover(Usuario $usuario, $perfilId)
    {
        return (bool) $usuario->perfis()->detach($perfilId);
    }

    /**
     * Define perfil informado como principal
     *
     * @param Usuario $usuario
     * @param int $perfilId
     *
     * @return bool
     */
    public function definirComoPrincipal(Usuario $usuario, $perfilId)
    {
        $perfil = Perfil::find($perfilId);

        $perfilPrincipalAtual = $usuario->perfis->filter(function($perfilTemp) use ($perfil) {
            return $perfilTemp->unidade_id === $perfil->unidade_id && $perfilTemp->pivot->principal;
        })->first();

        $arraySync = [];
        if ($perfilPrincipalAtual) {
            $arraySync[$perfilPrincipalAtual->id] = ['principal' => 0, 'ativo' => 1];
        }

        $arraySync[$perfil->id] = ['principal' => 1, 'ativo' => 1];

        // Define perfil principal atual como 0 e a informada como 1
        $usuario->perfis()->syncWithoutDetaching($arraySync);

        return true;
    }

    /**
     * Ativa perfil informado
     *
     * @param Usuario $usuario
     * @param int $perfilId
     *
     * @return bool
     */
    public function ativar(Usuario $usuario, $perfilId)
    {
        $usuario->perfis()->syncWithoutDetaching([
            $perfilId => ['principal' => 0, 'ativo' => 1]
        ]);

        return true;
    }

    /**
     * Desativa perfil informado
     *
     * @param Usuario $usuario
     * @param int $perfilId
     *
     * @return bool
     */
    public function desativar(Usuario $usuario, $perfilId)
    {
        $usuario->perfis()->syncWithoutDetaching([
            $perfilId => ['principal' => 0, 'ativo' => 0]
        ]);

        return true;
    }
}
