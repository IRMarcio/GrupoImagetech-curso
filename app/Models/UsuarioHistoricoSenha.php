<?php

namespace App\Models;

/**
 * Class Usuario
 *
 * Representa o histórico de senhas que o usuário já utilizou no sistema.
 *
 * @package App\Models
 */
class UsuarioHistoricoSenha extends BaseModel
{

    protected $table = 'usuario_historico_senha';

    protected $fillable = [
        'usuario_id',
        'senha'
    ];

    protected $hidden = [
        'senha'
    ];

}
