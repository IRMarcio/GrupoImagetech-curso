<?php

namespace App\Models;

class Secao extends BaseModel
{
    protected $table = 'secao';

    protected $casts = [
        'ativo' => 'boolean',
    ];

    protected $fillable = [
        'descricao',
        'ativo',
        'unidade_id',
    ];

    /**
     * Retorna a unidade.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }



}
