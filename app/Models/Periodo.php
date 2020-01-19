<?php

namespace App\Models;

class Periodo extends BaseModel
{

    protected $casts = [
        'sustentavel' => 'boolean'
    ];

    protected $fillable = [
        'codigo',
        'descricao',
        'sustentavel',
        'unidade_fornecimento',
        'tipo_periodo_id',
    ];

    /**
     * Tipo de produto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoPeriodo()
    {
        return $this->belongsTo(TipoPeriodo::class, 'tipo_periodo_id');
    }
}
