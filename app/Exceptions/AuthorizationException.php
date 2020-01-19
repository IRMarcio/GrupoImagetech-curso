<?php

namespace App\Exceptions;

/**
 * Classe utilizada para indicar que o usuário não tem permissão para executar a ação que ele tentou executar.
 *
 * @package App\Exceptions
 */
class AuthorizationException extends \Exception
{

    /**
     * Renderiza a exception.
     *
     * @param $request
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        flash('Você não tem permissão para acessar a página solicitada.')->error();

        return back();
    }
}
