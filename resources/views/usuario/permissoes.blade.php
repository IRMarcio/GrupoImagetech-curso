@extends('layouts.default')

@section('titulo_pagina', 'Permissões de usuário')

@section('breadcrumbs')
    <li><a href="{{ route('usuario.index') }}">Usuários</a></li>
    <li class="active">Permissões de usuário</li>
@endsection

@section('js')
    @parent
    <script src="{{ asset('assets/js/modulos/usuarios/gerenciapermissoes.js') }}"></script>
    <script src="{{ asset('assets/js/modulos/gerenciapermissoes.js') }}"></script>
@stop

@section('conteudo')
    <div class="panel panel-flat">
        <form action="{{ route('usuario.permissoes.post', $usuario) }}" method="post">
            <input type="hidden" name="usuario_id" value="{{ $usuario->id }}">
            <div class="panel-heading">
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a class="panel-filtro-usuario" data-action="collapse"></a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <p class="content-group">
                    Escolha abaixo um dos perfis do usuário para gerenciar. Lembre-se que estas permissões serão aplicadas somente ao usuário.
                </p>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <select name="perfil_id" class="form-control select2" required>
                                <option value=""></option>
                                @foreach($perfis as $grupo => $perfis)
                                    <optgroup label="{{ $grupo }}">
                                        @foreach($perfis as $perfil)
                                            <option value="{{ $perfil->id }}">{{ $perfil->nome }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div id="permissoes"></div>
            </div>
            <div class="panel-footer hide">
                <div class="heading-elements">
                    <div class="heading-btn pull-left">
                        <button type="submit" name="acao" value="salvar" class="btn btn-primary">
                            <i class="icon-database-check"></i>
                            Salvar
                        </button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>
@endsection