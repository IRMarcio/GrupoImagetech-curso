@extends('layouts.default')

@section('titulo_pagina', 'Adicionar Armazens para os Centro de Distribuição')

@section('breadcrumbs')
    <li><a href="{{ route('centro_distribuicao.index') }}">Armazens</a></li>
    <li class="active">Adicionar</li>
@endsection

@section('js')
    @parent
    <script src="{{ asset('assets/js/modulos/carregamunicipios.js') }}"></script>
@stop

@section('vue-componentes')
    <script src="{{ asset('assets/js/modulos/centro_distribuicao/form.js') }}"></script>
@stop

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form-us inline-template>
                <form action="{{ route('centro_distribuicao.adicionar_armazens.post', $centro_distribuicao) }}" method="POST" class="form-validate" @submit="salvar">
                    @include('centro_distribuicao.armazem.form')
                </form>
            </form-us>
        </div>
    </div>
@endsection
