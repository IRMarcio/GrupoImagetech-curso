<?php

use App\Models\CatMat;
use App\Models\Empresa;
use App\Models\Estado;
use App\Models\Motorista;
use App\Models\Municipio;
use App\Models\TipoProduto;
use App\Models\Veiculo;
use Illuminate\Support\Facades\Route;


//Estados
Route::group(['prefix' => 'estados', 'as' => 'estado.'], function () {
    rotasCrud('EstadoController', 'estado', Estado::class);
    Route::post('/', ['uses' => 'EstadoController@index', 'as' => 'index.post']);
});


//Municípios
Route::group(['prefix' => 'municipios', 'as' => 'municipio.'], function () {
    rotasCrud('MunicipioController', 'municipio', Municipio::class);
    Route::post('/', ['uses' => 'MunicipioController@index', 'as' => 'index.post']);
});


