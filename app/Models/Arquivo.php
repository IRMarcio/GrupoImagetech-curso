<?php

namespace App\Models;

/**
 * Representa um arquivo do sistema.
 *
 * @package App\Models
 */
class Arquivo extends BaseModel
{

    /**
     * A tabela utilizada para este model.
     *
     * @var string
     */
    protected $table = 'arquivo';

    protected $appends = ['url'];

    protected $fillable = [
        'nome',
        'mimetype',
        'tamanho',
        'model',
        'registro_id',
        'visualizacoes',
        'contar_visualizacoes',
        'publico'
    ];

    /**
     * Retorna em forma de texto o tamanho do arquivo.
     *
     * @return string
     */
    public function getTamanhoTextoAttribute()
    {
        return readableBytes($this->tamanho);
    }

    /**
     * @return string
     */
    public function getUrlAttribute()
    {
        return rotaArquivo($this);
    }

    public function conteudo()
    {
        return $this->hasOne(ArquivoConteudo::class, 'arquivo_id', 'id');
    }

}
