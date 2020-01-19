<?php

use App\Models\Auditoria;
use Illuminate\Support\Facades\Route;

    //Configiruções
Route::group(['prefix' => 'configuracoes', 'as' => 'configuracao.'], function () {
        Route::get('/', ['uses' => "ConfiguracaoController@index", 'as' => 'index']);
        Route::post('salvar', ['uses' => "ConfiguracaoController@salvar", 'as' => 'index.post']);
        Route::post('testar-email', ['uses' => "ConfiguracaoController@testarEmail", 'as' => 'testar_email.post']);
    });

    //Auditoria
Route::group(['prefix' => 'auditoria', 'as' => 'auditoria.'], function () {
        Route::model('auditoria', Auditoria::class);
        Route::get('/', ['uses' => 'AuditoriaController@index', 'as' => 'index']);
        Route::get('visualizar/{auditoria}', ['uses' => 'AuditoriaController@visualizar', 'as' => 'visualizar']);
    });

      // Movimentações --> rotas anteriores - **// VERIFICAR \\**
    /*incluirRotaDireta("_movimentacoes.php");*/
