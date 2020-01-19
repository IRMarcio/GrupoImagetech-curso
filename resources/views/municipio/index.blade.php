@extends('layouts.default')

@section('titulo_pagina', 'Municípios')

@section('breadcrumbs')
    <li class="active">Municípios</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <form action="{{ route('municipio.index') }}" method="get">
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
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-10">
                        <div class="form-group">
                            <label>Descrição:</label>
                            <input type="text" class="form-control" name="descricao" value="{{ request('descricao') }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
                        <div class="form-group">
                            <label>Estado:</label>
                            <select name="uf_id" class="form-control select2">
                                <option value=""></option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id }}" {{ request('uf_id', $filtros['uf_id']) == $estado->id ? 'selected' : '' }}>{{ $estado->uf }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="heading-elements">
                    <div class="heading-btn pull-left">
                        @include('partials.forms.botao_imprimir', ['url' => route('municipio.index')])
                        @include('partials.forms.botao_limpar', ['url' => route('municipio.index')])
                    </div>
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>

    @include('partials.painel_registros', [
        'listagem' => 'municipio.listagem',
        'prefixo' => 'municipio'
    ])
@endsection