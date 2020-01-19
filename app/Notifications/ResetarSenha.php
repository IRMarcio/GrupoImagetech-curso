<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Envia para o usuário um e-mail indicando para ele o link que ele deve clicar para resetar a senha.
 * Esse email é enviando quando um usuário do sistema necessita resetar a sua senha por esquecimento ou algum outro
 *     motivo.
 *
 * @package App\Notifications
 */
class ResetarSenha extends ResetPassword implements ShouldQueue
{

    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed $notifiable
     *
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $dados = [
            'nome'    => $notifiable->nome,
            'url'     => route('password.reset', $this->token),
            'sistema' => config('app.name')
        ];

        return (new MailMessage)
            ->markdown('mail.auth.resetar_senha', $dados)
            ->subject(config('app.name') . ' - Recuperação de senha');
    }
}
