@extends('layouts.default')

@section('titulo_pagina', 'Alterar Tipo de Peíodo')

@section('breadcrumbs')
    <li><a href="{{ route('tipo_periodo.index') }}">Tipos de Períodos</a></li>
    <li class="active">Alterar</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form action="{{ route('tipo_periodo.alterar.post', $tipoPeriodo) }}" method="POST" class="form-validate">
                @include('tipo_periodo.form')
            </form>
        </div>
    </div>
@endsection
