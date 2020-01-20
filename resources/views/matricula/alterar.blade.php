@extends('layouts.default')

@section('titulo_pagina', 'Alterar Matrícula')

@section('breadcrumbs')
    <li><a href="{{ route('estado.index') }}">Matrícula de Aluno</a></li>
    <li class="active">Alterar</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form action="{{ route('matricula.alterar.post', $estado) }}" method="POST" class="form-validate">
                @include('matricula.form')
            </form>
        </div>
    </div>
@endsection
