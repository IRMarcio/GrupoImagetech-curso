<?php

//Matriculas
use App\Models\Matricula;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'matriculas', 'as' => 'matricula.'], function () {
    rotasCrud('MatriculaController', 'matricula', Matricula::class);
    Route::post('/', ['uses' => 'MatriculaController@index', 'as' => 'index.post']);
});
