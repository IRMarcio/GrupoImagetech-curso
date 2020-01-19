@extends('layouts.default')

@section('titulo_pagina', 'Alterar Aluno')

@section('breadcrumbs')
    <li><a href="{{ route('aluno.index') }}">Alunos</a></li>
    <li class="active">Alterar</li>
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
            <form-us
                    inline-template
                    :aluno="{{ json_encode(isset($aluno->endereco)? $aluno->endereco: []) }}"
                    >
                <form action="{{ route('aluno.alterar.post', $aluno) }}" method="POST" class="form-validate" @submit="salvar">
                    @include('aluno.form')
                </form>
            </form-us>
        </div>
    </div>
@endsection
