@extends('layouts.default')

@section('titulo_pagina', 'Tipos de Períodos')

@section('breadcrumbs')
    <li class="active">Tipos de Períodos</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <form action="{{ route('tipo_periodo.index') }}" method="get">
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
                </div>
            </div>
            <div class="panel-footer">
                <div class="heading-elements">
                    <div class="heading-btn pull-left">
                        @include('partials.forms.botao_limpar', ['url' => route('tipo_periodo.index')])
                    </div>
                </div>
            </div>
        </form>
    </div>

    @include('partials.painel_registros', [
        'listagem' => 'tipo_periodo.listagem',
        'prefixo' => 'tipo_periodo'
    ])
@endsection
