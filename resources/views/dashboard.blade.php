@extends('layouts.default')

@section('titulo_pagina', '')

@section('js')
    @parent
    <script src="{{ asset('assets/js/plugins/d3.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/c3.min.js') }}"></script>
    <script src="{{ asset('assets/js/modulos/dashboard/c3_plugin_config.js') }}"></script>
    <script src="{{ asset('assets/js/modulos/dashboard/dashboard.js') }}"></script>
    <script>var chartValues = @json($dados);</script>
@stop
@section('style')


@stop

@section('conteudo')

    @can('previsao_entrega.index')
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="panel panel-body bg-blue-400 has-bg-image">
                    <div class="media no-margin">
                        <div class="media-body">
                            <h3 class="no-margin">{{$dados['produtos']}}</h3>
                            <span class="text-uppercase text-size-mini">Produtos/CatMat</span>
                        </div>

                        <div class="media-right media-middle">
                            <i class="icon-bag icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="panel panel-body bg-danger-400 has-bg-image">
                    <div class="media no-margin">
                        <div class="media-body">
                            <h3 class="no-margin">{{$dados['estoque_movimento']}}</h3>
                            <span class="text-uppercase text-size-mini">Movimentações</span>
                        </div>

                        <div class="media-right media-middle">
                            <i class="icon-car icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="panel panel-body bg-success-400 has-bg-image">
                    <div class="media no-margin">
                        <div class="media-left media-middle">
                            <i class="icon-archive icon-3x opacity-75"></i>
                        </div>

                        <div class="media-body text-right">
                            <h3 class="no-margin">{{ $dados['estoque'] }}</h3>
                            <span class="text-uppercase text-size-mini">Estoque</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="panel panel-body bg-indigo-400 has-bg-image">
                    <div class="media no-margin">
                        <div class="media-left media-middle">
                            <i class="icon-arrow-resize7 icon-3x opacity-75"></i>
                        </div>

                        <div class="media-body text-right">
                            <h3 class="no-margin">{{$dados['transferencias']}}</h3>
                            <span class="text-uppercase text-size-mini">Transferência</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h6 class="panel-title text-semibold">
                            <a class="heading-elements-toggle"><i class="icon-more"></i></a>
                        </h6>
                    </div>

                    <div class="panel-body">
                        <div class="chart-container">
                            <div class="chart" id="c3-transform"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h6 class="panel-title text-semibold">
                            <a class="heading-elements-toggle"><i class="icon-more"></i></a>
                        </h6>
                    </div>

                    <div class="panel-body">
                        <div class="chart-container">
                            <div class="chart" id="c3-transform-donut"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h6 class="panel-title text-semibold">
                            <a class="heading-elements-toggle"><i class="icon-more"></i></a>
                        </h6>
                    </div>

                    <div class="panel-body">
                        <div class="chart-container">
                            <div class="chart" id="c3-transform-area"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h6 class="panel-title text-semibold">
                            <a class="heading-elements-toggle"><i class="icon-more"></i></a>
                        </h6>
                    </div>

                    <div class="panel-body">
                        <div class="chart-container">
                            <div class="chart" id="c3-transform-catmat"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row ">
            <div class="col-lg-12">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h6 class="panel-title text-semibold">
                            <i class="icon-more">Painel Principal</i>
                        </h6>
                    </div>

                    <div class="panel-body">
                        <div class="panel-group-control">
                            <div class="img-thumbnail img-fluid" >
                                <img src="{{ asset('img/user_image.jpg') }}" alt="" width="50" height="50">
                            </div>
                            <span style="font-size: 16px;margin-left: 20px">{{ Auth()->user()->nome }}</span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="panel-heading">
                            <h5>Perfis do Usuário:</h5>
                        </div>
                        <div class="chart-container">
                            <ul>
                                @foreach(Auth()->user()->perfis as $perfil)
                                    <li>{{$perfil->nome}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="panel-heading">
                            <h5>Unidades do Usuário:</h5>
                        </div>
                        <div class="chart-container">
                            <ul>
                                @foreach(Auth()->user()->unidades() as $perfil)
                                    <li>{{$perfil->descricao}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection
