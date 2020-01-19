@extends('layouts.default')

@section('titulo_pagina', 'Usuários')

@section('breadcrumbs')
    <li class="active">Usuários</li>
@endsection

@section('js')
    @parent
    <script src="{{ asset('assets/js/modulos/usuario/index.js') }}"></script>
@stop

@section('acoes-com-registros-selecionados')
    @parent

    @can('usuario.invalidar_senha')    
    <a href="{{ route('usuario.invalidar_senha_varios.post') }}" class="btn btn-default btn-xs invalidar-senha-varios">
        <i class="icon-alert"></i>
        <span class="hidden-xs position-right">Invalidar senha</span>
    </a>
    @endcan

@stop

@section('conteudo')
    <div class="panel panel-flat">
        <form action="{{ route('usuario.index') }}" method="get">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Filtros
                </h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a class="panel-filtro-usuario" data-action="collapse"></a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Nome:</label>
                            <input type="text" class="form-control" name="nome" value="{{ request('nome') }}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>CPF:</label>
                            <input type="text" class="form-control mask-cpf" name="cpf" value="{{ request('cpf') }}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Situação:</label>
                            <select name="nuc_situacao_usuario_id" class="form-control select2">
                                <option value=""></option>
                                @foreach($situacoes as $situacao)
                                    <option {{ request("nuc_situacao_usuario_id") == $situacao->id ? 'selected' : '' }} value="{{ $situacao->id }}">{{ $situacao->descricao }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="heading-elements">
                    <div class="heading-btn pull-left">
                        @include('partials.forms.botao_imprimir', ['url' => route('usuario.index')])
                        @include('partials.forms.botao_limpar', ['url' => route('usuario.index')])
                    </div>
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>

    @include('partials.painel_registros', [
        'listagem' => 'usuario.listagem',
        'prefixo' => 'usuario'
    ])
@endsection
