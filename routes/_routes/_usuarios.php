<?php

use App\Models\Perfil;
use App\Models\SituacaoUsuario;
use App\Models\Usuario;
use Illuminate\Support\Facades\Route;

    /*//Usuários*/
Route::group(['prefix' => 'usuarios', 'as' => 'usuario.'], function () {
        rotasCrud("UsuarioController", 'usuario', Usuario::class);
        Route::model('situacaousuario', SituacaoUsuario::class);

        Route::get('permissoes/{usuario}', ['uses' => "UsuarioPermissaoController@index", 'as' => 'permissoes']);
        Route::post('permissoes/{usuario}', ['uses' => "UsuarioPermissaoController@salvar", 'as' => 'permissoes.post']);
        Route::post('validar-cpf', ['uses' => "UsuarioController@validarCpf", 'as' => 'validar_cpf.post']);
        Route::get('invalidar-senha/{usuario}', ['uses' => "UsuarioController@invalidarSenha", 'as' => 'invalidar_senha']);
        Route::post('invalidar-senha', ['uses' => "UsuarioController@invalidarSenhaVarios", 'as' => 'invalidar_senha_varios.post']);
        Route::get('remover-situacao/{usuario}/{situacaousuario}', ['uses' => "UsuarioController@removerSituacao", 'as' => 'remover_situacao']);
        Route::get('adicionar-situacao/{usuario}/{situacaousuario}', ['uses' => "UsuarioController@adicionarSituacao", 'as' => 'adicionar_situacao']);
        Route::get('ativar/{usuario}', ['uses' => "UsuarioController@ativar", 'as' => 'ativar']);
        Route::get('desativar/{usuario}', ['uses' => "UsuarioController@desativar", 'as' => 'desativar']);
        Route::get('desbloquear/{usuario}', ['uses' => "UsuarioController@desbloquearTentativas", 'as' => 'desbloquear_tentativas']);
    });

    /*//Perfis*/
Route::group(['prefix' => 'perfis', 'as' => 'perfil.'], function () {
        rotasCrud('PerfilController', 'perfil', Perfil::class);
        Route::post('/', ['uses' => 'PerfilController@index', 'as' => 'index.post']);
    });

    /*//Usuários/Perfis*/
Route::group(['prefix' => 'usuarios/perfis', 'as' => 'usuario_perfil.'], function () {
        Route::post('perfis-atribuidos', ['uses' => "Usuario\PerfilController@buscarPerfisAtribuidos", 'as' => 'perfis_atribuidos.post']);
        Route::post('validar-remocao-perfil', ['uses' => "Usuario\PerfilController@validarRemocaoPerfil", 'as' => 'validar_remocao_perfil.post']);
        Route::post('adicionar', ['uses' => "Usuario\PerfilController@adicionar", 'as' => 'adicionar.post']);
        Route::post('remover', ['uses' => "Usuario\PerfilController@remover", 'as' => 'remover.post']);
        Route::post('ativar', ['uses' => "Usuario\PerfilController@ativar", 'as' => 'ativar.post']);
        Route::post('desativar', ['uses' => "Usuario\PerfilController@desativar", 'as' => 'desativar.post']);
        Route::post('definir-como-principal', ['uses' => "Usuario\PerfilController@definirComoPrincipal", 'as' => 'definir_como_principal.post']);
    });

    /*//Permissões*/
Route::group(['prefix' => 'permissoes', 'as' => 'permissao.'], function () {
        Route::get('/', ['uses' => 'PermissaoController@index', 'as' => 'index']);
        Route::post('/', ['uses' => 'PermissaoController@index', 'as' => 'index.post']);
        Route::post('alterar', ['uses' => "PermissaoController@atualizar", 'as' => 'alterar.post']);
    });
