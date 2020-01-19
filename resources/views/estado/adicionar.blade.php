@extends('layouts.default')

@section('titulo_pagina', 'Adicionar Estado')

@section('breadcrumbs')
    <li><a href="{{ route('estado.index') }}">Estados</a></li>
    <li class="active">Adicionar</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form action="{{ route('estado.adicionar.post') }}" method="POST" class="form-validate">
                @include('estado.form')
            </form>
        </div>
    </div>
@endsection
