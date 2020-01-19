<?php

namespace App\Models;

class UnidadeCentroDistribuicao extends BaseModel
{

    protected $table = 'unidade_centro_distribuicao';

    protected $guarded = [];

    public function centro()
    {
        return $this->hasOne(TabCentroDistribuicao::class,'id','tab_centro_distribuicao_id');
    }

}
