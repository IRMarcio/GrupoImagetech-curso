@extends('layouts.default')

@section('titulo_pagina', 'Adicionar Usuário')

@section('breadcrumbs')
    <li><a href="{{ route('usuario.index') }}">Usuários</a></li>
    <li class="active">Adicionar</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form action="{{ route('usuario.adicionar.post', $usuario) }}" method="POST" class="form-usuario form-validate">
                @include('usuario.form')
            </form>
        </div>
    </div>
@endsection
