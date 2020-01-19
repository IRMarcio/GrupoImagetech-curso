@extends('layouts.default')

@section('titulo_pagina', 'Alterar Dados de Endereço de Centro de Distribuição')

@section('breadcrumbs')
    <li><a href="{{ route('centro_distribuicao.index') }}">Endereço do Centro de Distribuição</a></li>
    <li class="active">Alterar Endereço</li>
@endsection

@section('vue-componentes')
    <script src="{{ asset('assets/js/modulos/centro_distribuicao/form.js') }}"></script>
@stop


@section('conteudo')

    <div class="panel panel-flat">
        <div class="panel-body">
            <form-us
                    inline-template

                    :registro="{{ json_encode(isset($endereco)? $endereco: []) }}"
                    :registros="{{ json_encode(isset($enderecos)? $enderecos: []) }}"
                    :user="{{ json_encode(auth()->user()) }}"
            >

                <form ref="exec" action="{{ route('centro_distribuicao.alterar.endereco.post', $endereco) }}" method="POST"

                      class="form-validate" @submit="salvar">
                @include('centro_distribuicao.endereco.form')
            </form-us>
        </div>
    </div>
@endsection
