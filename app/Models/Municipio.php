<?php

namespace App\Models;

use App\Services\Mascarado;

class Municipio extends BaseModel
{

    protected $table = 'municipio';

    protected $fillable = [
        'descricao',
        'latitude',
        'longitude',
        'uf_id',
        'ind_cep_unico',
        'cep',
    ];

    /**
     * Remove mascara do CEP.
     *
     * @param string $valor
     */
    public function setCepAttribute($valor)
    {
        $this->attributes['cep'] = Mascarado::removerMascara($valor);
    }

    /**
     * Retorna a uf que este município pertence.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function uf()
    {
        return $this->belongsTo(Estado::class, 'uf_id');
    }
}
