<?php

//Cursos -> Curso
use App\Models\Curso;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'curso', 'as' => 'curso.'], function () {
    rotasCrud('CursoController', 'curso', Curso::class);
    Route::post('/', ['uses' => 'CursoController@index', 'as' => 'index.post']);
});
