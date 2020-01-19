<?php

namespace App\Services;

use App\Models\Usuario;

/**
 * Verifica se a senha do usuário é igual ao seu CPF. Se for, isso pode siginificar que este é o primeiro acesso
 * do usuário no sistema. Neste caso, sistema força o usuário a altera-la.
 *
 * @package App\Services
 */
class ChecagemSenhaPadrao
{

    /**
     * A regra é simples. Se a senha é igual ao CPF do usuário, quer dizer que ele ainda não alterou sua senha padrão.
     *
     * @param Usuario $usuario
     * @param $senha
     *
     * @return bool
     */
    public function necessitaAlterar(Usuario $usuario, $senha)
    {
        return Mascarado::removerMascara($usuario->cpf) == Mascarado::removerMascara($senha);
    }
}
