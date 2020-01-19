@extends('layouts.default')

@section('titulo_pagina', 'Alterar Período')

@section('breadcrumbs')
    <li><a href="{{ route('periodo.index') }}">PERÍODO</a></li>
    <li class="active">Alterar</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form action="{{ route('periodo.alterar.post', $periodo) }}" method="POST" class="form-validate">
                @include('periodo.form')
            </form>
        </div>
    </div>
@endsection
