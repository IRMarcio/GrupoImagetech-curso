<?php

namespace App\Services;

use App\Models\Rota;

/**
 * Dada uma rota do sistema, verifica se o usuário logado tem permissão para acessa-la.
 *
 * @package App\Services
 */
class ChecaPermissao
{

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    public function __construct(SessaoUsuario $sessaoUsuario)
    {
        $this->sessaoUsuario = $sessaoUsuario;
    }

    /**
     * Verifica se o usuário tem permissão para acessar a determinada rota.
     * Se tiver pelo menos um grupo dizendo que é permitida, este ganha.
     *
     * @param Rota $rota
     *
     * @return bool
     */
    public function temAcesso($rota)
    {
        // Todas os perfis que podem acessar a rota especificada
        $perfis = collect($rota->perfis)->pluck('id')->toArray();

        // Perfil que o usuário está logado
        $perfil = $this->sessaoUsuario->perfil();
        $excecao = collect($rota->excecoes)->where('perfil_usuario_id', $perfil->pivot->id)->first();

        // Se não foi dada permissão para nenhum perfil e não existe exceções, o usuário não tem permissão
        if (count($perfis) == 0 && $excecao === null) {
            return false;
        }

        // Caso tenhamos encontrado alguma exceção de permissão, vamos levar em consideração
        if ($excecao) {
            return $excecao->excecao == 1;
        }

        return in_array($perfil->id, $perfis);
    }
}
