<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @yield('titulo_pagina')
    </title>

    @include('partials.css')

    <meta name="_sitepath" content="{{ request()->root() }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>


    @if(request()->routeIs('dashboard'))
        <meta name="_prefixoRota" content="{{ request()->route()->getPrefix()}}"/>
    @endif

    <meta http-equiv="x-ua-compatible" content="IE=edge">
</head>

<body class=" navbar-bottom {{ isset($boxed) && $boxed === false ? '' : 'layout-boxed' }}">

<div id="app"
     sistema="{{ json_encode(config('sistema')) }}"
     slugid="{{ auth()->user() ? auth()->user()->slug_id : null }}"
     loginRoute="{{ route('login.post') }}"
     bloqueioTelaRoute="{{ route('bloquear_tela.post') }}"
     login="{{ auth()->user() ? auth()->user()->cpf : '' }}"
     v-cloak>

    <div id="bloco-bloqueio" v-show="telaBloqueada === true">
    </div>
    <div id="bloco-app" v-show="telaBloqueada === false">


        <!-- Page header -->
        <div class="page-header page-header-default">

            <!-- Main navbar -->
            <div class="navbar navbar-default" id="navbar-main">
                <div class="navbar-boxed">
                    @include('partials.barra_topo')
                </div>
            </div>
            <!-- /main navbar -->

            <!-- Second navbar -->
            <div class="navbar navbar-inverse" id="navbar-second">
                @include('partials.menu.menu_principal')
            </div>
            <!-- /second navbar -->

            <!-- Page header content -->
            <div class="page-header-content">
                @include('partials.titulo_pagina')
            </div>
            <!-- /page header content -->
        </div>
        <!-- /page header -->

        {{--Painel Lateral que indica mobilidade do sistema (Entrada->Saida de Material)--}}
        @can('previsao_entrega.index')
            @if(isset($logisticaExpedicao))
                @if(Route::currentRouteName() == 'dashboard')
                    @include('partials.dados', ['mostrar' => true])
                @else
                    @include('partials.dados', ['mostrar' => false])
                @endif
            @endif
        @endcan

        {{--Painel Lateral que indica Movimentação de Pedidos entre os Centro de Distribuição Matriz--}}
        @can('pedidos.index')
            @include('partials.card_dashboard_pedidos')
        @endcan
        @can('pedidos.requerimento_index')
            @include('partials.card_dashboard_andamentos')
        @endcan

        <div class="page-container">

            <div class="page-content">
                @yield('sidebar')
                @include('flash::message')
                @yield('conteudo')
            </div>

        </div>

        @section('modals')
        @show

    <!-- Footer -->
        <div class="navbar navbar-default navbar-fixed-bottom footer" style="position: fixed">
            @include('partials.rodape')
        </div>
        <!-- /footer -->

        @include('partials.modals.modal_ajax')
    </div>
</div>

@include('partials.js')
</body>

</html>
