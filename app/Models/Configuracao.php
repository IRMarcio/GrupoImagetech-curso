<?php

namespace App\Models;

class Configuracao extends BaseModel
{

    protected $table = 'configuracao';

    public static $acoesAposTimeoutSessao = [
        'L' => 'Forçar logout',
        'B' => 'Bloquear tela'
    ];

    protected $fillable = [
        'email_host',
        'email_porta',
        'email_encriptacao',
        'email_nome',
        'email',
        'email_senha',
        'timezone',
        'tempo_maximo_sessao',
        'acao_apos_timeout_sessao',
        'max_tentativas_login',
        'termos_uso',
        'dias_max_alterar_senha',
        'max_senhas_historico'
    ];
}
