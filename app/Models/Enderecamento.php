<?php

namespace App\Models;

class Enderecamento extends BaseModel
{
    protected $table = 'enderecamento';

    protected $fillable = [
        'area',
        'rua',
        'modulo',
        'nivel',
        'vao',
        'secao_id',
        'tipo_produto_id',
    ];

    /**
     * Retorna o endereço completo do tipo de produto.
     *
     * @return string
     */
    public function getEnderecoCompletoAttribute()
    {
        return "{$this->attributes['area']}-{$this->attributes['rua']}-{$this->attributes['modulo']}-{$this->attributes['nivel']}-{$this->attributes['vao']}";
    }

    /**
     * Dados do tipo de produto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoProduto()
    {
        return $this->belongsTo(TipoProduto::class, 'tipo_produto_id', 'id');
    }
    
    /**
     * Dados da seção.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function secao()
    {
        return $this->belongsTo(Secao::class, 'secao_id');
    }
}
