@extends('layouts.default')

@section('titulo_pagina', 'Adicionar Município')

@section('breadcrumbs')
    <li><a href="{{ route('municipio.index') }}">Municípios</a></li>
    <li class="active">Adicionar</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form action="{{ route('municipio.adicionar.post') }}" method="POST" class="form-validate">
                @include('municipio.form')
            </form>
        </div>
    </div>
@endsection
