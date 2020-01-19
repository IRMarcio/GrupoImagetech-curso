@extends('layouts.default')

@section('titulo_pagina', 'Adicionar PERÍODO')

@section('breadcrumbs')
    <li><a href="{{ route('periodo.index') }}">PERÍODO</a></li>
    <li class="active">Adicionar</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form action="{{ route('periodo.adicionar.post') }}" method="POST" class="form-validate">
                @include('periodo.form')
            </form>
        </div>
    </div>
@endsection
