<?php

use App\Models\Secao;
use App\Models\Unidade;
use Illuminate\Support\Facades\Route;

    /*//Unidade*/
Route::group(['prefix' => 'unidades', 'as' => 'unidade.'], function () {
        rotasCrud("UnidadeController", 'unidade', Unidade::class);
        Route::post('secoes', ['uses' => 'UnidadeController@carregarSecoes', 'as' => 'secoes.post']);
    });

    /*//Unidades/Seções*/
Route::group(['prefix' => 'unidades/secoes', 'as' => 'unidade_secao.'], function () {
        Route::model('unidade', Unidade::class);
        Route::model('secao', Secao::class);

        Route::post('/', ['uses' => 'Unidade\SecaoController@index', 'as' => 'index.post']);
        Route::post('salvar/{unidade}', ['uses' => "Unidade\SecaoController@salvar", 'as' => 'salvar.post']);
        Route::post('atualizar/{secao}', ['uses' => "Unidade\SecaoController@atualizar", 'as' => 'atualizar.post']);
        Route::post('excluir/{secao}', ['uses' => "Unidade\SecaoController@excluir", 'as' => 'excluir.post']);
        Route::post('validar-exclusao', ['uses' => "Unidade\SecaoController@validarExclusao", 'as' => 'validar_exclusao.post']);
    });
