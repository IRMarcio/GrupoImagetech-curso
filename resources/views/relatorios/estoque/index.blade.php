@extends('layouts.default')

@section('titulo_pagina', 'Estoque')

@section('breadcrumbs')
    <li class="active">Estoque</li>
@endsection

@section('js')
    @parent
    <script src="{{ asset('assets/js/modulos/carregaenderecoscd.js') }}"></script>
@stop

@section('conteudo')
    <div class="panel panel-flat">
        <form action="{{ route('relatorio_estoque.index') }}" method="GET">
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
                    @if ($usuarioLogado->super_admin || $usuarioLogado->gestor)
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Unidade:</label>
                                <select name="unidade_id" class="form-control select2 carregar-enderecos" data-target="secao_id" required>
                                    <option></option>
                                    @foreach($unidades as $unidade)
                                        <option {{ request('unidade_id') == $unidade->id ? 'selected' : '' }} value="{{ $unidade->id }}">
                                            {{ $unidade->descricao }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif


                    <div class="col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Endereços do Estoque:</label>
                            <select name="end_centro_id" class="form-control select2">
                                <option value="null">Selecionar....</option>
                                @if(isset($enderecos))
                                    @foreach($enderecos as $endereco)
                                        <option {{ request('end_centro_id') == $endereco->id ? 'selected' : '' }} value="{{ $endereco->id }}">
                                            {{ $endereco->area }}-{{ $endereco->rua }}-{{ $endereco->modulo }}-{{ $endereco->nivel }}-{{ $endereco->vao}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                    </div>

                    <div class="col-sm-4 col-md-2 col-lg-2">
                        <div class="form-group">
                            <label>Código CATMAT:</label>
                            <input type="text" class="form-control" name="codigo_catmat"
                                   value="{{ request('codigo_catmat') }}">
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-2 col-lg-2">
                        <div class="form-group">
                            <label>ID/CATMAT:</label>
                            <input type="text" class="form-control" name="id_catmat"
                                   value="{{ request('id_catmat') }}">
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Descrição produto:</label>
                            <input type="text" class="form-control" name="descricao_produto"
                                   value="{{ request('descricao_produto') }}">
                        </div>
                    </div>
                </div>

            </div>
            <div class="panel-footer">
                <div class="heading-elements">
                    <div class="heading-btn pull-left">
                        @include('partials.forms.botao_imprimir', ['url' => route('relatorio_estoque.index')])
                        @include('partials.forms.botao_limpar', ['url' => route('relatorio_estoque.index')])
                    </div>
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>


    @include('partials.painel_registros', [
        'listagem' => 'relatorios.estoque.listagem',
        'prefixo' => 'estoque'
    ])
@endsection
