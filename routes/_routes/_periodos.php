<?php

//Peridos -> Períodos
use App\Models\Periodo;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'periodo', 'as' => 'periodo.'], function () {
    rotasCrud('PeriodoController', 'periodo', Periodo::class);
    Route::post('/', ['uses' => 'PeriodoController@index', 'as' => 'index.post']);
});
