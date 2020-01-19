@extends('layouts.default')

@section('titulo_pagina', 'Alterar Estado')

@section('breadcrumbs')
    <li><a href="{{ route('estado.index') }}">Estados</a></li>
    <li class="active">Alterar</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form action="{{ route('estado.alterar.post', $estado) }}" method="POST" class="form-validate">
                @include('estado.form')
            </form>
        </div>
    </div>
@endsection
