<?php

namespace App\Models;

class EstocagemEndAlocacao extends BaseModel
{

    const ATIVO = 1;
    const INATIVO = 0;

    protected $table = 'estocagem_end_alocacao';

    protected $fillable = [
        'end_alocacao_id',
        'estocagem_id',
        'ativo'
    ];

    public function endereco(){
        return $this->HasOne(TabEndLocacao::class, 'id','end_alocacao_id');
    }

    public function movimento(){
            return $this->hasMany(EstoqueMovimento::class, 'estocagem_id','estocagem_id')->whereIn('tipo_movimento',[1,3]);
    }

    public function estocagem(){
        return $this->hasOne(Estocagem::class, 'id','estocagem_id');
    }


}
