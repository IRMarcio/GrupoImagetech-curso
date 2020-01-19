@extends('layouts.default')

@section('titulo_pagina', 'Alterar Endereçamento')

@section('breadcrumbs')
    <li><a href="{{ route('enderecamento.index') }}">Endereçamento</a></li>
    <li class="active">Alterar</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form action="{{ route('enderecamento.alterar.post', $enderecamento) }}" method="POST" class="form-validate">
                @include('enderecamento.form')
            </form>
        </div>
    </div>
@endsection