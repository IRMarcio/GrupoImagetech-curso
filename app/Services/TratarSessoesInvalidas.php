<?php

namespace App\Services;

use App\Services\GerenciaConfiguracoes;
use App\Services\GerenciaSession;
use Exception;
use Log;

class TratarSessoesInvalidas
{

    /**
     * @var GerenciaConfiguracoes
     */
    private $gerenciaConfiguracoes;

    /**
     * @var GerenciaSession
     */
    private $gerenciaSession;

    public function __construct(
        GerenciaConfiguracoes $gerenciaConfiguracoes,
        GerenciaSession $gerenciaSession)
    {
        $this->gerenciaConfiguracoes = $gerenciaConfiguracoes;
        $this->gerenciaSession = $gerenciaSession;
    }

    /**
     * Tratar sessões inválidas.
     * 
     * @return void
     */
    public function tratar()
    {
        // Configurações do sistema
        $configuracoes = $this->gerenciaConfiguracoes->buscarConfiguracoes();

        // Busca os ids dos usuário logados com sessões inválidas
        $usuarioIds = $this->gerenciaSession->buscarUsuarioLogadosSessoesInvalidas($configuracoes->tempo_maximo_sessao, false);

        // Se nenhum id foi retornado, já retorna
        if ( ! count($usuarioIds)) {
            return;
        }

        // Executa a ação determinada nas configurações do sistema para sessões inválidas
        foreach ($usuarioIds as $usuarioId) {

            switch ($configuracoes->acao_apos_timeout_sessao) {
                // Bloqueio de tela
                case 'B': 
                    $this->gerenciaSession->bloquearTelaPorInatividade($usuarioId);
                    break;

                // Forçar logout
                case 'L':
                    $this->gerenciaSession->forcarLogoutPorInatividade($usuarioId);
                    break;
            }
        }
    }
}
