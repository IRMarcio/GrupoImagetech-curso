@extends('layouts.default')

@section('titulo_pagina', 'Endereçamento')

@section('breadcrumbs')
    <li class="active">Endereçamento</li>
@endsection

@section('js')
    @parent
    <script src="{{ asset('assets/js/modulos/carregasecoes.js') }}"></script>
@stop

@section('conteudo')
    <div class="panel panel-flat">
        <form action="{{ route('enderecamento.index') }}" method="get">
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
                    {{-- <div class="col-xs-12 col-sm-8 col-md-8 col-lg-10">
                        <div class="form-group">
                            <label>Descrição:</label>
                            <input type="text" class="form-control" name="descricao" value="{{ request('descricao') }}">
                        </div>
                    </div> --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Tipo de produto:</label>
                            <select name="tipo_produto_id" class="form-control select2">
                                <option value=""></option>
                                @foreach($tiposProdutos as $tipoProduto)
                                    <option value="{{ $tipoProduto->id }}" {{ request('tipo_produto_id') == $tipoProduto->id ? 'selected' : '' }}>{{ $tipoProduto->descricao }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if ($usuarioLogado->super_admin || $usuarioLogado->gestor)
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Unidade:</label>
                                <select name="unidade_id" class="form-control select2 carregar-secoes" data-target="secao_id">
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
                            <label>Seção:</label>
                            <select name="secao_id" class="form-control select2">
                                <option></option>
                                @if(isset($secoes))
                                @foreach($secoes as $secao)
                                    <option {{ request('secao_id') == $secao->id ? 'selected' : '' }} value="{{ $secao->id }}">
                                        {{ $secao->descricao }}
                                    </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                </div>
            </div>
            <div class="panel-footer">
                <div class="heading-elements">
                    <div class="heading-btn pull-left">
                        @include('partials.forms.botao_imprimir', ['url' => route('enderecamento.index')])
                        @include('partials.forms.botao_limpar', ['url' => route('enderecamento.index')])
                    </div>
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>

    @include('partials.painel_registros', [
        'listagem' => 'enderecamento.listagem',
        'prefixo' => 'enderecamento'
    ])
@endsection
