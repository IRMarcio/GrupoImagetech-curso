@extends('layouts.default')

@section('titulo_pagina', 'Listagem de Matrícula')

@section('breadcrumbs')
    <li class="active">Matrículas de Alunos</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <form action="{{ route('matricula.index') }}" method="get">
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
                            <label>Aluno:</label>
                            <input type="text" class="form-control" name="aluno" value="{{ request('aluno') }}">
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Curso:</label>
                            <input type="text" class="form-control" name="curso" value="{{ request('curso') }}">
                        </div>
                    </div>

                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Período:</label>
                            <select name="periodo" class="form-control select2">
                                <option value=""></option>
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id }}" {{  (int)request('periodo') === $periodo->id ? "selected":'' }} >
                                        {{ $periodo->descricao }}
                                    </option>
                                @endforeach
                            </select>
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
                            <label>Status:</label>
                            <select name="status" class="form-control select2">
                                <option value=""></option>
                                @foreach($statusAll as $key => $status)
                                    <option value="{{ $key }}" {{  request('status') == (int)$key ? "selected":'' }} >
                                        {{ $status }}
                                    </option>
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
                        @include('partials.forms.botao_limpar', ['url' => route('matricula.index')])
                    </div>
                </div>
            </div>
        </form>
    </div>

    @include('partials.painel_registros', [
        'listagem' => 'matricula.listagem',
        'prefixo' => 'matricula'
    ])
@endsection
