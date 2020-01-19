@extends('layouts.blank')

@section('body', 'login-container bg-slate-800')

@section('titulo_pagina', 'Login')

@section('conteudo')
    <div class="page-container">
        <div class="page-content">
            <div class="content-wrapper">
                <form action="{{ route('login.post') }}" class="login-form form-validate" method="POST">
                    @include('flash::message')

                    <div class="panel panel-body" >
                        <div class="text-center" >
                            <img src="{{ asset('img/logo1.png') }}"  width="300" style="margin-left: 0px !important;" />
                            <hr />
                            <h5 class="content-group-lg">Faça login na sua conta
                                <small class="display-block">Entre com suas credenciais</small>
                            </h5>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <input autofocus type="text" class="form-control not-styled-label" placeholder="CPF ou CNS" name="login" required="required">
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <input type="password" class="form-control not-styled-label" placeholder="Senha" required name="password">
                            <div class="form-control-feedback">
                                <i class="icon-lock2 text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group login-options">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" class="styled" name="remember">
                                        Lembrar
                                    </label>
                                </div>
                                <div class="col-sm-12 mt-15">
                                    <a href="{{ route('esqueci') }}">Desbloquear/Esqueceu a senha?</a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn bg-blue btn-block">Login
                                <i class="icon-circle-right2 position-right"></i>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <small>{{ config('sistema.titulo') }} - {{ config('sistema.fornecedor') }} - {{ config('sistema.versao') }}</small>
                </form>
            </div>
        </div>
    </div>
@endsection
