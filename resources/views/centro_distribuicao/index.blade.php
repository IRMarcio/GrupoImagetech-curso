@extends('layouts.default')

@section('titulo_pagina', 'Centros de Distribuição')

@section('breadcrumbs')
    <li class="active">Centros de Distribuição</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <form action="{{ route('centro_distribuicao.index') }}" method="get">
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
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Descrição:</label>
                            <input type="text" class="form-control" name="descricao" value="{{ request('descricao') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="heading-elements">
                    <div class="heading-btn pull-left">
                        @include('partials.forms.botao_imprimir', ['relatorio' => 'centrodist.jrxml', 'saida' => 'centrodist'])
                        @include('partials.forms.botao_limpar', ['url' => route('centro_distribuicao.index')])
                    </div>
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>

    @include('partials.painel_registros', [
        'listagem' => 'centro_distribuicao.listagem',
        'prefixo' => 'centro_distribuicao'
    ])
@endsection
