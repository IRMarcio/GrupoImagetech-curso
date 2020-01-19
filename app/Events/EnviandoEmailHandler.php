<?php

namespace App\Events;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Mailer;
use App\Services\GerenciaConfiguracoes;

/**
 * Antes de enviar o e-mail o sistema executa este evento dando a oportunidade de controlar se ele
 * deve ser enviado (return true) ou não (return false).
 *
 * @package App\Events
 */
class EnviandoEmailHandler
{

    /**
     * Quando estiver para enviar um email.
     *
     * @param MessageSending $evento
     *
     * @return bool
     */
    public function onMessageSending(MessageSending $evento)
    {
        $gerenciaConfiguracoes = app(GerenciaConfiguracoes::class);
        $gerenciaConfiguracoes->limparCache();
        $configuracoes = $gerenciaConfiguracoes->buscarConfiguracoes();

        // Configura as credenciais de envio
        $this->configurarTransport($configuracoes);

        // Configra o nome que aparecerá de quem enviou o email
        $evento->message->setFrom($configuracoes->email, $configuracoes->email_nome);

        return true;
    }

    private function configurarTransport($configuracoes)
    {
        /** @var Mailer $mailer */
        $mailer = app('mailer');
        $transport = $mailer->getSwiftMailer()->getTransport();
        $transport->setHost($configuracoes->email_host);
        $transport->setPort($configuracoes->email_porta);
        $transport->setEncryption($configuracoes->email_encriptacao);
        $transport->setUsername($configuracoes->email);
        $transport->setPassword($configuracoes->email_senha);
    }
}
