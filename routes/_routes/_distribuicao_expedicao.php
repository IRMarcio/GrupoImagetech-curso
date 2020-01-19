<?php

use App\Models\ConhecimentoEmbarque;
use Illuminate\Support\Facades\Route;

    /*Conhecimento de embarque*/
Route::group(['prefix' => 'conhecimento-embarque', 'as' => 'conhecimento_embarque.'], function () {
        rotasCrud('ConhecimentoEmbarqueController', 'conhecimento_embarque', ConhecimentoEmbarque::class);
    });

    /*Nota Despacho rotas*/
Route::group(['prefix' => 'nota-despacho', 'as' => 'nota_despacho.'], function () {
        Route::get('/', ['uses' => 'NotaDespachoController@index', 'as' => 'index']);
        Route::post('salvar', ['uses' => 'NotaDespachoController@salvar', 'as' => 'index.post']);
    });

    /*Lista Embalagens rotas*/
Route::group(['prefix' => 'lista-embalagens', 'as' => 'lista_embalagens.'], function () {
        Route::get('/', ['uses' => 'ListaEmbalagemController@index', 'as' => 'index']);
        Route::get('/lista-embalagens/{embalagem}', ['uses' => 'ListaEmbalagemController@gerar', 'as' => 'gerar']);
        Route::post('salvar', ['uses' => 'ListaEmbalagemController@salvar', 'as' => 'index.post']);
    });

    /*Expedicao rotas*/
Route::group(['prefix' => 'expedicao', 'as' => 'expedicao.'], function () {
        rotasCrud('ExpedicaoController', 'expedicao', ConhecimentoEmbarque::class);
    });

    /*Manifest Expedicao rotas*/
Route::group(['prefix' => 'manifesto-expedicao', 'as' => 'manifesto_expedicao.'], function () {
        rotasCrud('ManifestoExpedicaoController', 'manifesto_expedicao', ConhecimentoEmbarque::class);
    });
