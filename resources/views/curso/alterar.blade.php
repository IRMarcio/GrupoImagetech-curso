@extends('layouts.default')

@section('titulo_pagina', 'Alterar Curso')

@section('breadcrumbs')
    <li><a href="{{ route('curso.index') }}">CURSO</a></li>
    <li class="active">Alterar</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form action="{{ route('curso.alterar.post', $curso) }}" method="POST" class="form-validate">
                @include('curso.form')
            </form>
        </div>
    </div>
@endsection
