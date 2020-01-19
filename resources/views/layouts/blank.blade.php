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

    @include('partials.css')
</head>

<body class="@yield('body')">
<div id="app" 
    sistema="{{ json_encode(config('sistema')) }}" 
    slugid="{{ auth()->user() ? auth()->user()->slug_id : null }}" 
    loginRoute="{{ route('login.post') }}"
    bloqueioTelaRoute="{{ route('bloquear_tela.post') }}"
    login="{{ auth()->user() ? (auth()->user()->cpf ?: auth()->user()->cns) : '' }}"
    v-cloak>

    <div id="bloco-bloqueio" v-show="telaBloqueada === true">
    </div>
    <div id="bloco-app" v-show="telaBloqueada === false">
        @yield('conteudo')
    </div>
</div>
@section('modals')
@show
@include('partials.js')
</body>
</html>
