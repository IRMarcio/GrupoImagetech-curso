@extends('layouts.default')

@section('titulo_pagina', 'Adicionar Aluno')

@section('breadcrumbs')
    <li><a href="{{ route('aluno.index') }}">Alunos</a></li>
    <li class="active">Adicionar</li>
@endsection

@section('js')
    @parent
    <script src="{{ asset('assets/js/modulos/carregamunicipios.js') }}"></script>
@stop

@section('vue-componentes')
    <script src="{{ asset('assets/js/modulos/aluno/form.js') }}"></script>
@stop

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form-us inline-template>
                <form action="{{ route('aluno.adicionar.post', $aluno) }}" method="POST" class="form-validate" @submit="salvar">
                    @include('aluno.form')
                </form>
            </form-us>
        </div>
    </div>
@endsection
