<?php

//CentroCursoss -> CentroCursos
use App\Models\CentroCurso;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'centro-curso', 'as' => 'centro_curso.'], function () {
    rotasCrud('CentroCursosController', 'centro_curso', CentroCurso::class);
    Route::post('/', ['uses' => 'CentroCursosController@index', 'as' => 'index.post']);
});
