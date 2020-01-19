<?php

namespace App\Models;

class Curso extends BaseModel
{

    protected $casts = [
        'ativo' => 'boolean'
    ];

    protected $fillable = [
        'codigo',
        'nome',
        'descricao',
        'valor_mensalidade',
        'valor_matricula',
        'unidade_fornecimento',
        'tipo_periodo_id',
        'ativo',
        'duracao'
    ];

    /**
     * Formatar entrada de valor currency em banco de dados
     *
     * @param $value
     */
    public function setValorMensalidadeAttribute($value)
    {
        $valor = str_replace(['.', 'R$ ', ','], ['', '', '.'], $value);
        $this->attributes['valor_mensalidade'] = $valor;
    }

    /**
     * Formatar saída de dados para view;
     * @return float;
     * */
    public function getValorMensalidadeAttribute()
    {
        return str_replace([".", ","], [",", "."], $this->attributes['valor_mensalidade']);

    }

    /**
     * Formatar entrada de valor currency em banco de dados
     *
     * @param $value
     */
    public function setValorMatriculaAttribute($value)
    {

        $valor = str_replace(['.', 'R$ ', ','], ['', '', '.'], $value);

        $this->attributes['valor_matricula'] = $valor;
    }


    /**
     * Formatar saída de dados para view;
     * @return float;
     * */
    public function getValorMatriculaAttribute()
    {
        return str_replace([".", ","], [",", "."], $this->attributes['valor_matricula']);
    }

    /**
     * Formatar saída de dados para view;
     * @return float;
     * */
    public function setTipoPeriodoIdAttribute()
    {
        $this->attributes['tipo_periodo_id'] =  json_encode(request()->get('tipo_periodo_id'));
    }

    /**
     * Tipo de produto.
     *
     * @return string
     */
    public function tipoPeriodo($value)
    {
        return  TipoPeriodo::whereIn('id',json_decode($value,true))->pluck('descricao');
    }
}
