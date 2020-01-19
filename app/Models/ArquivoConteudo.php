<?php

namespace App\Models;

/**
 * Representa o conteúdo de arquivo do sistema.
 *
 * @package App\Models
 */
class ArquivoConteudo extends BaseModel
{

    /**
     * A tabela utilizada para este model.
     *
     * @var string
     */
    protected $table = 'arquivo_conteudo';

    protected $fillable = [
        'conteudo',
        'arquivo_id'
    ];

}
