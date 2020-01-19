<?php

use App\Models\TabCentroDistribuicao;
use Illuminate\Support\Facades\Route;

    // Centro de Distribuição
Route::group(['prefix' => 'centro-distribuicao', 'as' => 'centro_distribuicao.'], function () {
        rotasCrud("CentroDistribuicaoController", 'centro_distribuicao', TabCentroDistribuicao::class);

        /*Adicionar Armazens aos Centros de Distribuição*/
        Route::post('secoes', ['uses' => 'CentroDistribuicaoController@carregarSecoes', 'as' => 'secoes.post']);
        Route::post('carregar-produtos', ['uses' => 'CentroDistribuicaoController@carregarProdutos', 'as' => 'produtos.post']);
        Route::post('carregar-todos-produtos', ['uses' => 'CentroDistribuicaoController@carregarTodosProdutos', 'as' => 'produtos.post']);
        Route::post('enderecos', ['uses' => 'CentroDistribuicaoController@carregarEnderecos', 'as' => 'enderecos.post']);
        Route::get('enderecos/alterar/{endereco}', ['uses' => 'CentroDistribuicaoController@alterarEndereco', 'as' => 'alterar.endereco']);
        Route::post('enderecos/alterar', ['uses' => 'CentroDistribuicaoController@alterarEnderecoPost', 'as' => 'alterar.endereco.post']);
    });

//Endereçamentos de Cargas do Centro de Distribuição
Route::group(['prefix' => 'enderecamento-cargas', 'as' => 'enderecamento_cargas.'], function () {
        Route::get('cargas', ['uses' => 'CentroDistribuicaoController@visualizarEstoqueCd', 'as' => 'estocagem_']);
        Route::get('adicionar', ['uses' => 'EnderecoAlocacaoController@adicionar', 'as' => 'adicionar']);
        Route::post('adicionar/endereco', ['uses' => 'EnderecoAlocacaoController@salvar', 'as' => 'salvar']);
        Route::post('delete', ['uses' => 'CentroDistribuicaoController@deleteEnderecoPost', 'as' => 'endereco.delete']);
    });
