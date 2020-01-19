<?php
//Tipos de Período
use App\Models\TipoPeriodo;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'tipo_periodo', 'as' => 'tipo_periodo.'], function () {
    rotasCrud('TipoPeriodoController', 'tipoPeriodo', TipoPeriodo::class);
    Route::post('/', ['uses' => 'TipoPeriodoController@index', 'as' => 'index.post']);
});
