@extends('layouts.default')

@section('titulo_pagina', 'Auditoria')

@section('breadcrumbs')
    <li class="active">Auditoria</li>
@endsection

@section('js')
    @parent
    <script src="{{ asset('assets/js/modulos/carregarotas.js') }}"></script>
@stop


@section('conteudo')
    <div class="panel panel-flat">
        <form action="{{ route('auditoria.index') }}" method="get">
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
                    <div class="col-sm-4 col-md-4 col-lg-6">
                            <div class="form-group">
                                <label>Ação:</label>
                                <input name="descricao_acao" value="{{ request('descricao_acao') }}" class="form-control" />
                            </div>
                        </div>

                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Usuário:</label>
                            <select name="nuc_usuario_id" class="form-control select2">
                                <option value=""></option>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" {{ request('nuc_usuario_id') == $usuario->id ? 'selected' : '' }}>{{ $usuario->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-3 col-md-3 col-lg-2">
                        <div class="form-group">
                            <label>Data:</label>
                            <input type="text" placeholder="dd/mm/aaaa" class="form-control input-datepicker mask-date" name="data" value="{{ request('data') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="heading-elements">
                    <div class="heading-btn pull-left">
                        @include('partials.forms.botao_imprimir', ['url' => route('auditoria.index')])
                        @include('partials.forms.botao_limpar', ['url' => route('auditoria.index')])
                    </div>
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>

    @include('partials.painel_registros', [
        'prefixo' => 'auditoria',
        'checkbox' => false
    ])
@endsection
