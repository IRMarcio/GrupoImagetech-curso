<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_sitepath" content="{{ request()->root() }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    @if (request()->route())
        <meta name="_prefixoRota" content="{{ request()->route()->getPrefix() }}"/>
    @endif

    <title>
        @if (isset($moduloAtivo))
            @yield('titulo_pagina') - {{ $moduloAtivo->nome }} - {{ config('sistema.titulo') }}
        @else
            @yield('titulo_pagina') - {{ config('sistema.titulo') }}
        @endif
    </title>

    <link href="{{ asset('assets/css/errorpage.css') }}" rel="stylesheet" type="text/css">
</head>

<body class="@yield('body')">
<div id="app">
    @yield('conteudo')
</div>
@section('modals')
@show
</body>
</html>
