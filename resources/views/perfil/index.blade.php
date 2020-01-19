@extends('layouts.default')

@section('titulo_pagina', 'Perfis')

@section('breadcrumbs')
    <li class="active">Perfis</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <form action="{{ route('perfil.index') }}" method="get">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Filtros
                </h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Descrição:</label>
                            <input type="text" class="form-control" name="nome" value="{{ request('nome') }}">
                        </div>
                    </div>
                    @if (auth()->user()->gestor || auth()->user()->super_admin)
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Unidade:</label>
                            <select name="unidade_id" class="form-control select2">
                                <option value=""></option>
                                @foreach($dependencias['unidades'] as $unidade)
                                    <option value="{{ $unidade->id }}" {{ request('unidade_id') == $unidade->id ? 'selected' : '' }}>{{ $unidade->descricao }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="panel-footer">
                <div class="heading-elements">
                    <div class="heading-btn pull-left">
                        @include('partials.forms.botao_imprimir', ['url' => route('perfil.index')])
                        @include('partials.forms.botao_limpar', ['url' => route('perfil.index')])
                    </div>
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>

    @include('partials.painel_registros', [
        'listagem' => 'perfil.listagem',
        'prefixo' => 'perfil'
    ])
@endsection
