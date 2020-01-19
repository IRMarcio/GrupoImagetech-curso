<?php


use Illuminate\Support\Facades\Route;

    /*// Selecionar a unidade ativa*/
    Route::get('selecionar', ['uses' => 'SelecionarUnidadeController@index', 'as' => 'selecionar_unidade']);
    Route::post('selecionar', ['uses' => 'SelecionarUnidadeController@selecionar', 'as' => 'selecionar_unidade.post']);

    /*// DashBoard Autenticado*/
    Route::get('/', ['uses' => 'DashboardController@index', 'as' => 'dashboard']);

    /*// Altarar Perfil de Usuário logado no sistema;*/
    Route::get('alterar-perfil', ['uses' => 'UsuarioController@alterarPerfil', 'as' => 'usuario.alterar_perfil']);
    Route::post('alterar-perfil', ['uses' => 'UsuarioController@salvarPerfil', 'as' => 'usuario.alterar_perfil.post']);

    /*// Altarar Senha de Usuário logado no sistema;*/
    Route::get('alterar-senha', ['uses' => 'UsuarioController@alterarSenha', 'as' => 'usuario.alterar_senha']);
    Route::post('alterar-senha', ['uses' => 'UsuarioController@salvarSenha', 'as' => 'usuario.alterar_senha.post']);

