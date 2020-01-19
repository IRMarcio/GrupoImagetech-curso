@extends('layouts.default')

@section('titulo_pagina', 'Alterar senha')

@section('breadcrumbs')
    <li class="active">Alterar senha</li>
@endsection

@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('assets/js/plugins/passy.min.js') }}"></script>
    <script>
        $(function () {
            $.passy.requirements.length.min = 4;
            const $novaSenha = $('input[name="nova_senha"]');
            const $novaSenhaSaida = $novaSenha.parents('.row').find('.label');

            const feedback = [
                {color: '#D55757', text: 'Fraco', textColor: '#fff'},
                {color: '#EB7F5E', text: 'Normal', textColor: '#fff'},
                {color: '#3BA4CE', text: 'Bom', textColor: '#fff'},
                {color: '#40B381', text: 'Forte', textColor: '#fff'}
            ];

            $novaSenha.passy(function (strength) {
                if ($novaSenha.val()) {
                    $novaSenhaSaida.text(feedback[strength].text);
                    $novaSenhaSaida.css('background-color', feedback[strength].color).css('color', feedback[strength].textColor);
                }
            });
        })
    </script>
@stop

@section('conteudo')
    @include('partials.usuario.regras_senha_segura')

    <div class="clearfix"></div>

    <div class="panel panel-flat">

        <form action="{{ route('usuario.alterar_senha.post') }}" class="form-validate" method="post">
            <div class="panel-body">
                <p class="content-group">
                    Utilize o formulário abaixo para alterar a sua senha. Lembre-se de criar uma senha forte mas fácil de lembrar.
                </p>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Senha Atual:</label>
                            <input autofocus type="password" class="form-control" name="senha" required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Nova senha:</label>
                            <input type="password" class="form-control" name="nova_senha" required data-rule-minLength="8">
                            <span class="label indicador-senha"></span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Confirme a nova senha:</label>
                            <input type="password" class="form-control" name="nova_senha_confirmation" required data-rule-minLength="8">
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
