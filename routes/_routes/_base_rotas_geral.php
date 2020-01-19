<?php


use App\Models\Arquivo;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
        return redirect()->route('dashboard');
    });

Route::get('/report/{jrxmlName}/{outputFile}/{parameter?}', 'ReportController@getReport')->name('report');

Route::group(['middleware' => ['auth']], function () {
        Route::post('broadcasting/auth', ['uses' => '\App\Http\Controllers\BroadcastController@authenticate']);
    });

Route::group(['middleware' => ['web', 'auth', 'auditoria']], function () {
        Route::get('aceite_termos_uso', ['uses' => 'TermosUsoController@aceite', 'as' => 'termos_uso.aceite']);
        Route::post('aceite_termos_uso', ['uses' => 'TermosUsoController@registrarAceite', 'as' => 'termos_uso.aceite.post']);
    });

// Rotas de login do usuário no sistema
Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login', 'middleware' => ['auditoria']]);
Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::post('bloquear-tela', ['middleware' => ['auth', 'web', 'auditoria'], 'uses' => 'UsuarioController@bloquearTela', 'as' => 'bloquear_tela.post']);

Route::model('arquivo', Arquivo::class);
Route::group(['middleware' => ['auth', 'web'], 'prefix' => 'arquivos', 'as' => 'arquivo.'], function () {
    //    Route::post('upload', ['as' => 'upload.post', 'uses' => 'ArquivoController@upload']);
    //    Route::get('visualizar/{arquivo}/{usuarioId?}', ['as' => 'visualizar', 'uses' => 'ArquivoController@visualizar']);
    });

Route::get('esqueci', ['as' => 'esqueci', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('esqueci', ['as' => 'esqueci.post', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('esqueci/resetar/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
Route::post('esqueci/resetar', ['as' => 'password.reset.post', 'uses' => 'Auth\ResetPasswordController@reset']);

Route::group(['middleware' => ['web', 'logado']], function () {
        Route::post('selecionar/buscar-perfis', ['uses' => 'SelecionarUnidadeController@buscarPerfis', 'as' => 'selecionar_buscar_perfis.post']);
    });
