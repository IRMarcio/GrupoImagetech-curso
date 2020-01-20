@extends('layouts.default')

@section('titulo_pagina', 'Adicionar Matrícula')

@section('breadcrumbs')
    <li><a href="{{ route('matricula.index') }}">Matrícula</a></li>
    <li class="active">Adicionar</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form action="{{ route('matricula.adicionar.post') }}" method="POST" class="form-validate">
                @include('matricula.form')
            </form>
        </div>
    </div>
@endsection
