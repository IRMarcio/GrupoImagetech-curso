<?php

use App\Models\CatMat;
use App\Models\Empresa;
use App\Models\Estado;
use App\Models\Motorista;
use App\Models\Municipio;
use App\Models\TipoProduto;
use App\Models\Veiculo;
use Illuminate\Support\Facades\Route;

//
//    // Veículos
//Route::group(['prefix' => 'veiculos', 'as' => 'veiculo.'], function () {
//        rotasCrud('VeiculoController', 'veiculo', Veiculo::class);
//        Route::post('/', ['uses' => 'VeiculoController@index', 'as' => 'index.post']);
//    });
//
//    // Motoristas
//Route::group(['prefix' => 'motoristas', 'as' => 'motorista.'], function () {
//        rotasCrud('MotoristaController', 'motorista', Motorista::class);
//        Route::post('/', ['uses' => 'MotoristaController@index', 'as' => 'index.post']);
//    });
//
//
//    //CatMat -> Produtos
//Route::group(['prefix' => 'catmat', 'as' => 'catmat.'], function () {
//        rotasCrud('CatmatController', 'catmat', Catmat::class);
//        Route::post('/', ['uses' => 'CatmatController@index', 'as' => 'index.post']);
//    });

    //Estados
Route::group(['prefix' => 'estados', 'as' => 'estado.'], function () {
        rotasCrud('EstadoController', 'estado', Estado::class);
        Route::post('/', ['uses' => 'EstadoController@index', 'as' => 'index.post']);
    });

//    //Tipos de Produtos
//Route::group(['prefix' => 'tipos_produtos', 'as' => 'tipo_produto.'], function () {
//        rotasCrud('TipoProdutoController', 'tipoProduto', TipoProduto::class);
//        Route::post('/', ['uses' => 'TipoProdutoController@index', 'as' => 'index.post']);
//    });

    //Municípios
Route::group(['prefix' => 'municipios', 'as' => 'municipio.'], function () {
        rotasCrud('MunicipioController', 'municipio', Municipio::class);
        Route::post('/', ['uses' => 'MunicipioController@index', 'as' => 'index.post']);
    });

//    //Transportadoras
//Route::group(['prefix' => 'transportadoras', 'as' => 'transportadora.'], function () {
//        rotasCrud('TransportadoraController', 'empresa', Empresa::class);
//        Route::post('/', ['uses' => 'TransportadoraController@index', 'as' => 'index.post']);
//    });
//
//    //Fornecedores
//Route::group(['prefix' => 'fornecedores', 'as' => 'fornecedor.'], function () {
//        rotasCrud('FornecedorController', 'empresa', Empresa::class);
//        Route::post('/', ['uses' => 'FornecedorController@index', 'as' => 'index.post']);
//    });
//
//    //Entrada de Produtos
//Route::group(['prefix' => 'entrada', 'as' => 'entrada_produto.'], function () {
//        Route::get('/', ['uses' => 'EntradaProdutoController@index', 'as' => 'index']);
//        Route::post('/', ['uses' => 'EntradaProdutoController@salvar', 'as' => 'index.post']);
//    });



// Endereçamentos - **//VERIFICAR\\**
//Route::group(['prefix' => 'enderecamentos', 'as' => 'enderecamento.'], function () {
//        rotasCrud('EnderecamentoController', 'enderecamento', Enderecamento::class);
//        Route::post('/', ['uses' => 'EnderecamentoController@index', 'as' => 'index.post']);
//    });

