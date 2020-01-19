<?php

namespace App\Models;

use App\Scopes\IgnorarTemporarioScope;
use App\Services\Mascarado;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class Aluno extends BaseModel
{

    protected $table = 'alunos';

    protected $casts = [
        'ativo' => 'boolean'
    ];

    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'cpf',
        'rg',
        'telefone',
        'ativo',
        'dt_nascimento',
        'centro_distribuicao_id'

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
     * Retorna formato correto para salvar no bando de Dados;
     * @return string
     * */
    public function setDtNascimentoAttribute($value)
    {
       return $this->attributes['dt_nascimento'] = Carbon::createFromFormat('d/m/Y', $value)->format('y-m-d 00:00:00');
    }
    /**
     * Retorna formato correto para salvar no bando de Dados;
     * @return string
     * */
    public function setCpfAttribute($value)
    {
       return $this->attributes['cpf'] = Mascarado::removerMascara($value);
    }

    /**
     * Retorna o Relação de Endereço do Aluno.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function endereco()
    {
        return $this->hasOne(TabEndereco::class, 'aluno_id');
    }

}
