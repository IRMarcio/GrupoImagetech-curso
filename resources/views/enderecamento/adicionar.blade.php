@extends('layouts.default')

@section('titulo_pagina', 'Adicionar Endereçamento')

@section('breadcrumbs')
    <li><a href="{{ route('enderecamento.index') }}">Endereçamento</a></li>
    <li class="active">Adicionar</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form action="{{ route('enderecamento.adicionar.post') }}" method="POST" class="form-validate">
                @include('enderecamento.form')
            </form>
        </div>
    </div>
@endsection
