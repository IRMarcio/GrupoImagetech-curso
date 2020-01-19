<?php

namespace App\Models;

use App\Scopes\IgnorarTemporarioScope;
use App\Services\Mascarado;
use Illuminate\Contracts\Support\Arrayable;

class TabEndereco extends BaseModel
{

    protected $table = 'endereco';


    protected $casts = [
        'ativo' => 'boolean',
        'geo_localizacao' => 'array'

    ];

    protected $fillable = [
        'centro_distribuicao_id',
        'aluno_id',
        'telefone',
        'fax',
        'email',
        'municipio_id',
        'uf_id',
        'endereco',
        'bairro',
        'numero',
        'complemento',
        'cep',
        'latitude',
        'longitude',
    ];



    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new IgnorarTemporarioScope);
    }

    /**
     * Retorna o município.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    /**
     * Retorna formato correto para salvar no bando de Dados;
     * @return string
     * */
    public function setCepAttribute($value)
    {
        return $this->attributes['cep'] = Mascarado::removerMascara($value);
    }

    /**
     *
     * @return array;
     */
    public function getGeoLocalizacaoAttribute()
    {

        if($this->attributes['latitude'] == null){
            return [$this->attributes['endereco']];
        }
        return [$this->attributes['latitude'], $this->attributes['longitude']];
    }
}
