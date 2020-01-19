@extends('layouts.default')

@section('titulo_pagina', 'Estados')

@section('breadcrumbs')
    <li class="active">Estados</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <form action="{{ route('estado.index') }}" method="get">
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
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="form-group">
                            <label>Descrição:</label>
                            <input type="text" class="form-control" name="descricao" value="{{ request('descricao') }}">
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Sigla:</label>
                            <input type="text" class="form-control" name="uf" value="{{ request('uf') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="heading-elements">
                    <div class="heading-btn pull-left">
                        @include('partials.forms.botao_imprimir', ['relatorio' => 'uf.jrxml', 'saida' => 'uf'])
                        @include('partials.forms.botao_limpar', ['url' => route('estado.index')])
                    </div>
                </div>
            </div>
        </form>
    </div>

    @include('partials.painel_registros', [
        'listagem' => 'estado.listagem',
        'prefixo' => 'estado'
    ])
@endsection
