<?php

namespace App\Events;

use App\Services\GerenciaSession;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Models\Usuario;

/**
 * Escuta eventos que acontecem relacionados ao login/logout de um usuário no sistema e realiza ações de acordo.
 *
 * @package App\Events
 */
class UsuarioEventHandler
{
    /**
     * @var GerenciaSession
     */
    private $gerenciaSession;

    public function __construct(GerenciaSession $gerenciaSession)
    {
        $this->gerenciaSession = $gerenciaSession;
    }

    /**
     * Quando um usuário no sistema fizer login, seta o módulo ativo baseado no request e limpa-o em seguida para
     * garantir o descobrimento do módulo ativo posteriormente.
     *
     * @param Login $evento
     *
     * @throws \Exception
     */
    public function onLogin(Login $evento)
    {
        auth()->user()->update(['ultimo_login' => now(config('app.timezone'))->toDateTimeString()]);
    
    }

    /**
     * Quando o usuário tiver uma tentantiva de login falha.
     *
     * @param Failed $evento
     */
    public function onLoginFail(Failed $evento)
    {
        if (!$evento->user) {
            return;
        }
        
        $usuarioId = $evento->user->getAuthIdentifier();
        auditar('usuario', $usuarioId, 'login_erro', $usuarioId, 'I');
    }

    /**
     * Quando o usuário realizar logout no sistema limpa os dados do módulo ativo.
     *
     * @param Logout $evento
     *
     * @throws \Exception
     */
    public function onLogout(Logout $evento)
    {
        if (isset($evento->user->id)) {
            $usuarioId = $evento->user->id;
            auditar('usuario', $usuarioId, 'logout', $usuarioId, 'I');
        }

        cache()->flush();
    }

    /**
     * Após X tentativas de login (configuradas no sistema) erradas, o usuário cai neste evento.
     *
     * @param Lockout $evento
     *
     * @return bool
     */
    public function onLockout(Lockout $evento)
    {
        $request = $evento->request;
        $login = $request->get('login');
        $usuario = Usuario::where('cpf', $login)->first();

        if ($usuario) {
            if ($usuario->temSituacao('bloqueado_tentativa') == false) {
                $usuario->adicionarSituacao('bloqueado_tentativa');

                flash('Por segurança, a sua conta foi bloqueada por muitas tentativas de login sem sucesso seguidamente. Aguarde alguns minutos para fazer login novamente.')->error();
                auditar('usuario', $usuario->id, 'tentativas_login', $usuario->id, 'U');

                // Efetua logout automático de todas sessions/abas abertas
                $this->gerenciaSession->forcarLogoutPorInatividade($usuario->id, false);
            } else {
                flash('Aguarde alguns minutos para fazer login novamente.')->error();
            }
        }
    }
}
