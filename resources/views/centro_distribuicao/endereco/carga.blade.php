@extends('layouts.default')

@section('titulo_pagina', 'Alterar Centro de Distribuição')

@section('breadcrumbs')
    <li><a href="{{ route('centro_distribuicao.index') }}">Centro de Distribuição</a></li>
    <li class="active">Visualizar Cargas Endereços</li>
@endsection


@section('vue-componentes')
    <script src="{{ asset('assets/js/modulos/centro_distribuicao/form.js') }}"></script>
@stop


@section('conteudo')

    <div class="panel panel-flat">
        <div class="panel-body">
            <form-us inline-template
                     :registro="{{ json_encode(isset($endereco) ? $endereco: []) }}">
                @include('centro_distribuicao._aba_deposito_alocacao')
            </form-us>
        </div>
    </div>
@endsection
