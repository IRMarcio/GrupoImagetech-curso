@extends('layouts.default')

@section('titulo_pagina', 'Alterar Dados de Endereço de Centro de Distribuição')

@section('breadcrumbs')
    <li><a href="{{ route('centro_distribuicao.index') }}">Endere&ccedil;o do Centro de Distribui&ccedil;&atilde;o</a>
    </li>
    <li class="active">Alterar Endere&ccedil;o</li>
@endsection

@section('vue-componentes')
    <script src="{{ asset('assets/js/modulos/centro_distribuicao/create_endereco.js') }}"></script>
@stop


@section('conteudo')

    <div class="panel panel-flat">
        <div class="panel-body">

            <create-endereco inline-template
                             :_enderecos="{{ isset($enderecos) ? json_encode($enderecos): [] }}">
                <form ref="exec" action="{{ route('enderecamento_cargas.salvar') }}" method="POST"
                      class="form-validate" @submit="salvar">
                    @include('centro_distribuicao.endereco.adicionar_form')
                </form>
            </create-endereco>
        </div>
    </div>
@endsection
