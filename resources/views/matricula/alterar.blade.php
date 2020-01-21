@extends('layouts.default')

@section('titulo_pagina', 'Alterar Matrícula')

@section('breadcrumbs')
    <li><a href="{{ route('matricula.index') }}">Matrícula de Aluno</a></li>
    <li class="active">Alterar</li>
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
                     :alterar=true
            >
                <form action="{{ route('matricula.alterar.post', $matricula) }}" method="POST"
                      class="form-validate" @submit="salvar">
                @include('matricula.form')
            </form-us>
        </div>
    </div>
@endsection
