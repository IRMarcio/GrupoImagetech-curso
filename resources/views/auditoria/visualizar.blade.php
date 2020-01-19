<?php
$tabelasIgnoradas = [

];
?>

@extends('layouts.default')

@section('titulo_pagina', 'Auditoria - Detalhes')

@section('breadcrumbs')
    <li><a href="{{ route('auditoria.index') }}">Auditoria</a></li>
    <li class="active">Detalhes</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">
                Detalhes
            </h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td width="15%"><strong>Tipo:</strong></td>
                                <td>{{ $auditoria->tipo->descricao }}</td>
                            </tr>
                            <tr>
                                <td width="15%"><strong>Ação:</strong></td>
                                <td>{{ $auditoria->descricao_acao }}</td>
                            </tr>
                            <tr>
                                <td width="15%"><strong>Responsável:</strong></td>
                                <td>{{ $auditoria->usuario->nome }}</td>
                            </tr>
                            <tr>
                                <td width="15%"><strong>Data:</strong></td>
                                <td>{{ formatarData($auditoria->created_at, 'd/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <td width="15%"><strong>IP:</strong></td>
                                <td>{{ $auditoria->endereco_ipv4 }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <br>
                        {{-- <div class="row-fluid">
                            <div class="span12">
                                <div class="control-group">
                                    <label class="control-label">Dados $_GET:</label>

                                    <div class="controls">
                                        <pre>{{ $auditoria->dados_get }}</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="control-group">
                                    <label class="control-label">Dados $_POST:</label>

                                    <div class="controls">
                                        <pre>{{ $auditoria->dados_post }}</pre>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="control-group">
                                    <label class="control-label">Dados $_SERVER:</label>

                                    <div class="controls">
                                        <pre>{{ $auditoria->dados_server }}</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="clearfix"></div>
                    <div class="text-right">
                        <a href="{{ route('auditoria.index') }}" class="btn btn-default">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($auditoria->acoes as $acao)
        <div class="lista panel panel-default">
            <div class="panel-body"><h2>Ação #{{ $acao->id }}</h2>
                
                <div class="table-responsive">
                    <table class="table table-vertical-center table-primary table-thead-simple">
                        <tbody>
                        <tr>
                            <td width="30%"><strong>Tabela:</strong></td>
                            <td>{{ $acao->tabela }}</td>
                        </tr>
                        <tr>
                            <td width="30%"><strong>Registro:</strong></td>
                            <td>{{ $acao->registro_id }}</td>
                        </tr>
                        <tr>
                            <td width="30%"><strong>Ação na tabela:</strong></td>
                            <td>{{ $acao->acao_tabela_texto }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                </div>
                @if (in_array($acao->tabela, $tabelasIgnoradas))
                <div class="row-fluid">
                    <div class="span12">
                         <div class="alert alert-warning alert-styled-left content-group">
                            <span class="text-semibold">Dados restritos.</span>
                        </div>
                    </div>
                </div>
                @elseif (count($acao->dados_campos['campos']))
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="control-group">
                                <label class="control-label">Dados:</label>

                                <div class="controls">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <td><strong>Campo</strong></td>
                                                <td><strong>Antigo</strong></td>
                                                <td><strong>Novo</strong></td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($acao->dados_campos['campos'] as $campo)
                                                <tr>
                                                    <td width="20%">{{ $campo }}</td>
                                                    <td width="40%" {!! $acao->dados_campos['old'][$campo]['alterado'] ? 'style="font-weight: bold;"' : '' !!}>
                                                        {{ $acao->dados_campos['old'][$campo]['valor'] }}
                                                    </td>
                                                    <td width="40%" {!! $acao->dados_campos['new'][$campo]['alterado'] ? 'style="font-weight: bold;"' : '' !!}>
                                                        {{ $acao->dados_campos['new'][$campo]['valor'] }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <p>Nenhuma alteração de dados</p>
                @endif
            </div>
        </div>
    @endforeach
@endsection
