<?php
//Fornecedores
use App\Models\Aluno;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'alunos', 'as' => 'aluno.'], function () {
    rotasCrud('AlunoController', 'empresa', Aluno::class);
    Route::post('/', ['uses' => 'AlunoController@index', 'as' => 'index.post']);
});
