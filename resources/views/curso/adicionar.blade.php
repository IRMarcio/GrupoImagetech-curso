@extends('layouts.default')

@section('titulo_pagina', 'Adicionar CURSO')

@section('breadcrumbs')
    <li><a href="{{ route('curso.index') }}">CURSO</a></li>
    <li class="active">Adicionar</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">

            <form action="{{ route('curso.adicionar.post') }}" method="POST" class="form-validate">
                @include('curso.form')
            </form>
        </div>
    </div>
@endsection
