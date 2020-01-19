@extends('layouts.blank')

@section('body', 'login-container bg-slate-800')

@section('titulo_pagina', 'Selecionar Centro de Distribuição')

@section('js')
    @parent
    <script src="{{ asset('assets/js/modulos/carregaperfisdaunidade.js') }}"></script>
@stop

@section('conteudo')
    <div class="page-container">
        <div class="page-content">
            <div class="content-wrapper">
                <form action="{{ route('selecionar_unidade.post') }}" class="login-form form-validate" method="POST">
                    @include('flash::message')

                    <div class="panel panel-body">
                        <div class="text-center">
                            <div class="icon-object border-warning-400 text-warning-400">
                                <i class="icon-city"></i>
                            </div>
                            <h5 class="content-group-lg">
                                Centro de distribuição e perfil:
                            </h5>
                        </div>

                        <div class="form-group">
                            <label>Selecione o centro de distribuição:</label>
                            <select 
                                name="unidade_id" 
                                class="form-control select2 carregar-perfis-da-unidade" 
                                data-target="perfil_id" 
                                required>
                                @foreach($unidades as $i => $unidade)
                                    <option 
                                        {{ $preSelecao['unidade_id'] == $unidade->id || (!$preSelecao['unidade_id'] && $i == 0) ? 'selected' : '' }}
                                        value="{{ $unidade->id }}">{{ $unidade->descricao }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Selecione o perfil que deseja logar:</label>
                            <select name="perfil_id" class="form-control select2" required>
                                @foreach($preSelecao['perfis'] as $perfil)
                                    <option value="{{ $perfil->id }}">{{ $perfil->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn bg-blue btn-block">Continuar
                                <i class="icon-circle-right2 position-right"></i>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
@stop
