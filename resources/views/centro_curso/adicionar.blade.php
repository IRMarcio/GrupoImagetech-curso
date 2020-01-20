@extends('layouts.default')

@section('titulo_pagina', 'Adicionar Curso Centro')

@section('breadcrumbs')
    <li><a href="{{ route('centro_curso.index') }}">Adicionar Curso ao Centro</a></li>
    <li class="active">Adicionar</li>
@endsection

@section('vue-componentes')
    @parent
    <script src="{{ asset('assets/js/modulos/centro_curso/form.js') }}"></script>
    <script src="{{ asset('assets/js/modulos/centro_curso/centro_curso.js') }}"></script>
@stop


@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form-us inline-template>
                <form action="{{ route('centro_curso.adicionar.post') }}" method="POST"
                      class="form-validate" @submit="salvar">
                @include('centro_curso.form')
                @include('partials.forms.botao_salvar', ['voltar' => 'centro_curso.index'])
            </form-us>
        </div>
    </div>
@endsection
