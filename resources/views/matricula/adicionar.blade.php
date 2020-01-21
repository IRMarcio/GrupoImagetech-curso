@extends('layouts.default')

@section('titulo_pagina', 'Adicionar Matrícula')

@section('breadcrumbs')
    <li><a href="{{ route('matricula.index') }}">Matrícula</a></li>
    <li class="active">Adicionar</li>
@endsection

@section('vue-componentes')
    @parent
    <script src="{{ asset('assets/js/modulos/matricula/form.js') }}"></script>
@stop

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form-us inline-template
                     :alunos="{{ json_encode(isset($alunos) ? $alunos : [])}}"
                     :matricula="{{ json_encode(isset($matricula) ? $matricula : [])}}"
                     :cursos_add="{{ json_encode(isset($centroCursos) ? $centroCursos : [])}}"
            >
                <form action="{{ route('matricula.adicionar.post') }}" method="POST"
                      class="form-validate" @submit="salvar">
                @include('matricula.form')
            </form-us>
        </div>
    </div>
@endsection
