<?php

namespace App\Services;

use App\Events\BloquearTela;
use App\Events\DesbloquearTela;
use App\Events\ForcarLogout;
use App\Models\Session;
use App\Models\Usuario;
use DB;
use Log;

class GerenciaSession
{

    /**
     * Valida se sessão do usuário informado está ou não vencida
     *
     * @param int $usuarioId
     * @param $tempoMaximoSessao
     *
     * @return bool
     */
    public function sessaoUsuarioEhValida($usuarioId, $tempoMaximoSessao)
    {
        $registros = DB::table('sessions')
                       ->select(DB::raw('MAX(last_activity) as time_ultima_atividade, user_id'))
                       ->where('user_id', $usuarioId)
                       ->groupBy('user_id')
                       ->havingRaw('(MAX(last_activity) + ' . ($tempoMaximoSessao * 60) . ') > ' . time())
                       ->get();

        return (bool)$registros->count() > 0;
    }

    /**
     * verifica se sessão do usuário está bloqueada
     *
     * @param int $usuarioId
     *
     * @return bool
     */
    public function sessaoUsuarioEstaBloqueada($usuarioId)
    {
        $registro = Session::where('user_id', $usuarioId)
                           ->orderBy('last_activity', 'DESC')
                           ->first();


        if (!$registro) {
            return false;
        }

        return $registro->bloqueada;
    }

    /**
     * Busca ids dos usuários logados com sessões inválidas (vencidas)
     *
     * @param int $tempoMaximoSessao
     * @param bool $sessaoBloqueada
     *
     * @return Array
     */
    public function buscarUsuarioLogadosSessoesInvalidas($tempoMaximoSessao, $sessaoBloqueada = null)
    {
        // Busca todas sessões 
        // onde o user_id não é nulo
        // onde o a última atividade + tempo máximo da sessão em minutos * 60 (transformar em segundos) seja menor 
        // que o time atual
        $query = DB::table('sessions')
                   ->select(DB::raw('MAX(last_activity) as time_ultima_atividade, user_id'))
                   ->whereNotNull('user_id')
                   ->groupBy('user_id')
                   ->havingRaw('(MAX(last_activity) + ' . ($tempoMaximoSessao * 60) . ') < ' . time());

        if (!is_null($sessaoBloqueada)) {
            $query->where('bloqueada', $sessaoBloqueada ? 1 : 0);
        }

        $sessoesInvalidas = $query->get();

        return $sessoesInvalidas->count() ? $sessoesInvalidas->pluck('user_id')->toArray() : [];
    }

    /**
     * Envia sinal para bloqueio de tela do usuário informado
     * Registra na auditoria que bloqueio de tela foi efetuado por sessão expirada
     * Seta sessão como bloqueada
     *
     * @param int $usuarioId
     *
     * @return void
     */
    public function bloquearTelaPorInatividade($usuarioId)
    {
        // Busca registro do usuário para pegar o slud_id
        $usuario = Usuario::find($usuarioId);

        // Auditar
        auditar('usuario', $usuarioId, 'tela_bloqueada_inatividade', $usuarioId, 'I');

        // Bloqueia registros da sessão do usuário informado
        $this->bloquearSessoesUsuario($usuarioId);

        // Envia sinal
        broadcast(new BloquearTela($usuario->slug_id));
    }

    /**
     * Bloqueia sessões do usuário informado
     *
     * @param int $usuarioId
     *
     * @return void
     */
    private function bloquearSessoesUsuario($usuarioId)
    {
        Session::where('user_id', $usuarioId)->update(['bloqueada' => true]);
    }

    /**
     * Envia sinal para bloqueio de tela do usuário informado
     * Registra na auditoria que bloqueio de tela foi efetuado pelo usuário
     * Seta sessão como bloqueada
     *
     * @param int $usuarioId
     *
     * @return void
     */
    public function bloquearTela($usuarioId)
    {
        // Busca registro do usuário para pegar o slud_id
        $usuario = Usuario::find($usuarioId);

        // Auditar
        auditar('usuario', $usuarioId, 'tela_bloqueada', $usuarioId, 'I');

        // Bloqueia registros da sessão do usuário informado
        $this->bloquearSessoesUsuario($usuarioId);

        // Envia sinal
        broadcast(new BloquearTela($usuario->slug_id));
    }

    /**
     * Envia sinal para desbloqueio de tela do usuário informado
     * Registra na auditoria que desbloqueio de tela foi efetuado
     * Seta sessão como desbloqueada
     *
     * @param int $usuarioId
     *
     * @return void
     */
    public function desbloquearTela($usuarioId)
    {
        // Busca registro do usuário para pegar o slud_id
        $usuario = Usuario::find($usuarioId);

        // Desbloqueia registros da sessão do usuário informado
        $this->desbloquearSessoesUsuario($usuarioId);

        // Auditar
        auditar('usuario', $usuarioId, 'tela_desbloqueada', $usuarioId, 'I');

        // Envia sinal
        broadcast(new DesbloquearTela($usuario->slug_id));
    }

    /**
     * Desbloqueia sessões do usuário informado
     *
     * @param int $usuarioId
     *
     * @return void
     */
    private function desbloquearSessoesUsuario($usuarioId)
    {
        Session::where('user_id', $usuarioId)->update(['bloqueada' => false]);
    }

    /**
     * Envia sinal para forçar logout do usuário informado
     * Registra na auditoria que logout foi efetuado por sessão expirada
     *
     * @param int $usuarioId
     * @param bool $auditar
     *
     * @return void
     * */
    public function forcarLogoutPorInatividade($usuarioId, $auditar = true)
    {
        // Busca registro do usuário para pegar o slud_id
        $usuario = Usuario::find($usuarioId);

        // Exclui registros da sessão do usuário informado
        $this->excluirSessoesUsuario($usuarioId);

        // Auditar
        if ($auditar) {
            auditar('usuario', $usuarioId, 'logout_sessao_expirada', $usuarioId, 'I');
        }

        // Envia sinal
        broadcast(new ForcarLogout($usuario->slug_id));
    }

    /**
     * Exclui sessões do usuário informado
     *
     * @param int|null $usuarioId
     *
     * @return void
     */
    public function excluirSessoesUsuario($usuarioId = null)
    {
        $session = Session::query();
        if (!is_null($usuarioId)) {
            $session->where('user_id', $usuarioId);
        }

        $session->delete();
    }
}
