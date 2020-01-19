<?php

use Illuminate\Support\Facades\Route;

    /*//Relatórios*/
Route::group(['prefix' => 'relatorios'], function () {
        /*// Estoque*/
        Route::group(['prefix' => 'estoque', 'as' => 'relatorio_estoque.'], function () {
            Route::get('/', ['uses' => 'Relatorios\EstoqueController@index', 'as' => 'index']);
            Route::get('/listagem/produtos', ['uses' => 'Relatorios\EstoqueController@listEndEstoque', 'as' => 'listagem_endereco']);
        });
    });
