@extends('layouts.default')

@section('titulo_pagina', 'Alterar Perfil')

@section('breadcrumbs')
    <li><a href="{{ route('perfil.index') }}">Perfis</a></li>
    <li class="active">Alterar</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form action="{{ route('perfil.alterar.post', $perfil) }}" method="POST" class="form-validate">
                @include('perfil.form')
            </form>
        </div>
    </div>
@endsection