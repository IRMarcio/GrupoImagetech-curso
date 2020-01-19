@extends('layouts.blank')

@section('body', 'login-container bg-slate-800')

@section('titulo_pagina', 'Esqueci a senha')

@section('conteudo')
    <div class="page-container">
        <div class="page-content">
            <div class="content-wrapper">
                <form action="{{ route('esqueci.post') }}" class="login-form form-validate" method="POST">
                    @include('flash::message')

                    <div class="panel panel-body">
                        <div class="text-center">
                            <div class="icon-object border-warning-400 text-warning-400"><i class="icon-people"></i>
                            </div>
                            <h5 class="content-group-lg">Esqueci minha senha
                                <small class="display-block">Informe o seu CPF ou CNS e lhe enviaremos um e-mail com as instruções necessários para cadastrar uma nova senha</small>
                            </h5>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <input autofocus type="text" class="form-control" placeholder="CPF ou CNS" name="login" required="required">
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn bg-blue btn-block">Enviar
                                <i class="icon-circle-right2 position-right"></i>
                            </button>
                        </div>

                        <a href="{{ route('login') }}">
                            <small>Ir para o login</small>
                        </a>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
@endsection
