@extends('layouts.blank')

@section('body', 'login-container bg-slate-800')

@section('titulo_pagina', 'Alterar senha')

@section('modals')
    @parent
    @include('partials.modal_regras_senha_segura')
@endsection

@section('conteudo')
    <div class="page-container">
        <div class="page-content">
            <div class="content-wrapper">
                <form action="{{ route('password.reset.post') }}" class="login-form form-validate" method="POST">
                    <input type="hidden" name="token" value="{{ $token }}">
                    @include('flash::message')

                    <div class="panel panel-body">
                        <div class="text-center">
                            <div class="icon-object border-warning-400 text-warning-400"><i class="icon-people"></i>
                            </div>
                            <h5 class="content-group-lg">Definir nova senha
                                <small class="display-block">Preencha o seu CPF/CNS utilizado no sistema e a sua nova senha abaixo</small>
                            </h5>
                        </div>

                        <p>
                            <a href="#" data-target="#regras-senha" data-toggle="modal"><i class="icon-circle-right2"></i> Regras para uma senha segura</a>
                        </p>

                        <div class="form-group has-feedback has-feedback-left">
                            <input autofocus type="text" class="form-control" placeholder="CPF ou CNS" name="login" required="required" value="{{ old('login') }}">
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <input type="password" class="form-control" placeholder="Nova senha" name="password" required="required" data-rule-minLength="8">
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <input type="password" class="form-control" placeholder="Confirme a nova senha" name="password_confirmation" required="required" data-rule-minLength="8">
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
