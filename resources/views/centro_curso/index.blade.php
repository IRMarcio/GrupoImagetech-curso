@extends('layouts.default')

@section('titulo_pagina', 'Curso CDEstudantil')

@section('breadcrumbs')
    <li class="active">Curso do Disponíveis no Centro</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <form action="{{ route('centro_curso.index') }}" method="get">
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
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Curso:</label>
                            <input type="text" class="form-control" name="curso" value="{{ request('curso') }}">
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Turma:</label>
                            <input type="number" class="form-control" name="turma" value="{{ request('turma') }}">
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Tipo de períodos:</label>
                            <select name="tipo_periodo_id" class="form-control select2">
                                <option value=""></option>
                                @foreach($tipoPeriodos as $tipoPeriodo)
                                    <option value="{{ $tipoPeriodo->id }}" {{ request('tipo_periodo_id') == $tipoPeriodo->id ? 'selected' : '' }}>{{ $tipoPeriodo->descricao }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="heading-elements">
                    <div class="heading-btn pull-left">
                        @include('partials.forms.botao_imprimir', ['relatorio' => 'uf.jrxml', 'saida' => 'uf'])
                        @include('partials.forms.botao_limpar', ['url' => route('centro_curso.index')])
                    </div>
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>

    @include('partials.painel_registros', [
        'listagem' => 'centro_curso.listagem',
        'prefixo' => 'centro_curso',
        'label' => 'Adicionar/Alterar Cursos'
    ])
@endsection
