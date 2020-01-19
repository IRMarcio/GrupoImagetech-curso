@extends('layouts.default')

@section('titulo_pagina', 'Alterar perfil')

@section('breadcrumbs')
    <li class="active">Alterar perfil</li>
@endsection

@section('conteudo')
    <div class="panel panel-flat">
        <form action="{{ route('usuario.alterar_perfil.post') }}" class="form-validate" method="post">
            <div class="panel-body">
                <p class="content-group">
                    Utilize o formulário abaixo para alterar o seu perfil de usuário.
                </p>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Perfil:</label>
                                <select name="perfil_id" class="form-control select2" required>
                                    <option value=""></option>
                                    @foreach($perfis as $perfil)
                                        <option value="{{ $perfil->id }}">{{ $perfil->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="heading-elements">
                    <div class="heading-btn pull-left">
                        <button type="submit" class="btn btn-primary">
                            <b><i class="icon-database-check"></i></b> Salvar
                        </button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>
@endsection