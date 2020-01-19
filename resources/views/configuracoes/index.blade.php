@extends('layouts.default')

@section('titulo_pagina', 'Configurações do sistema')

@section('breadcrumbs')
    <li class="active">Configurações</li>
@endsection

@section('js')
    @parent
    <script src="{{ asset('assets/js/modulos/configuracao/index.js') }}"></script>
@stop

@section('conteudo')
    <div class="panel panel-white">
        <form action="{{ route('configuracao.index.post') }}" name="configuracoes" class="form-validate" method="post">
            <div class="panel-body">

                <fieldset class="content-group">
                    <legend class="text-bold">Configurações gerais</legend>
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 col-md-4 col-lg-3">
                            <div class="form-group">
                                <label>Fuso horário:</label>
                                <select name="timezone" class="form-control select2" required title="Fuso horário">
                                    <option value=""></option>
                                    @foreach($fusos as $fuso)
                                        <option {{ $config->timezone == $fuso ? 'selected' : '' }} value="{{ $fuso }}">{{ $fuso }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-3 col-md-4 col-lg-2">
                            <div class="form-group">
                                <label for="max_tentativas_login">Máx. tentativas de login:</label>
                                <input type="text" name="max_tentativas_login" id="max_tentativas_login" class="form-control" value="{{ $config->max_tentativas_login }}"/>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label for="max_tentativas_login">Tempo para troca de senha:</label>
                                <div class="input-group">
                                    <input type="text" name="dias_max_alterar_senha" id="dias_max_alterar_senha" class="form-control" value="{{ $config->dias_max_alterar_senha }}" required/>
                                    <span class="input-group-addon">dias</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label for="max_tentativas_login">Máx. histórico de senhas:</label>
                                <div class="input-group">
                                    <input type="text" name="max_senhas_historico" id="max_senhas_historico" class="form-control" value="{{ $config->max_senhas_historico }}" required/>
                                    <span class="input-group-addon">senhas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                
                {{-- <fieldset class="content-group">
                    <legend class="text-bold">Sessão do usuário</legend>

                    <div class="form-group col-lg-2 col-sm-4">
                        <label for="tempo_maximo_sessao">Tempo máximo de sessão:</label>

                        <div class="input-group">
                            <input type="text" required name="tempo_maximo_sessao" id="tempo_maximo_sessao" class="form-control required mask-inteiro text-right" value="{{ $config->tempo_maximo_sessao }}"/>
                            <span class="input-group-addon">minutos</span>
                        </div>
                    </div>

                    <div class="form-group col-lg-3 col-sm-4">
                        <label for="acao_apos_timeout_sessao">Ação após sessão expirar:</label>
                        <select name="acao_apos_timeout_sessao" class="form-control select2" required>
                            <option value=""></option>
                            @foreach($acoesAposTimeoutSessao as $valorAcao => $descricaoAcao)
                                <option {{ $config->acao_apos_timeout_sessao == $valorAcao ? 'selected' : '' }} value="{{ $valorAcao }}">{{ $descricaoAcao }}</option>
                            @endforeach
                        </select>
                    </div>
                </fieldset> --}}

                <fieldset class="content-group">
                    <legend class="text-bold">
                        <span class="pull-left">Configurações de e-mail</span>
                        <span class="pull-right">
                            <button class="btn btn-info" id="testar-email" type="button">Testar conexão com email</button>
                        </span>
                    </legend>

                    <div class="form-group col-lg-6 col-sm-4">
                        <label for="email_host">Host:</label>
                        <input type="text" name="email_host" id="email_host" class="form-control" value="{{ $config->email_host }}"/>
                        <small>Ex.: smtp.gmail.com</small>
                    </div>
                    <div class="form-group col-lg-2 col-sm-4">
                        <label for="email_porta">Porta:</label>
                        <input type="text" name="email_porta" id="email_porta" class="form-control" value="{{ $config->email_porta }}"/>
                        <small>Ex.: 587</small>
                    </div>
                    <div class="form-group col-lg-2 col-sm-4">
                        <label for="email_encriptacao">Método de encriptação:</label>
                        <input type="text" name="email_encriptacao" id="email_encriptacao" class="form-control" value="{{ $config->email_encriptacao }}"/>
                        <small>Ex.: tls</small>
                    </div>
                    <div class="form-group col-lg-4 col-sm-4">
                        <label for="email_nome">Nome:</label>
                        <input type="text" name="email_nome" id="email_nome" class="form-control" value="{{ $config->email_nome }}"/>
                    </div>
                    <div class="form-group col-lg-4 col-sm-4">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ $config->email }}"/>
                        <small>Informe o email utilizado para o envio de emails no sistema.</small>
                    </div>
                    <div class="form-group col-lg-4 col-sm-4">
                        <label for="email_senha">Senha:</label>
                        <input type="password" autocomplete="new-password" name="email_senha" id="email_senha" class="form-control" value="{{ $config->email_senha }}"/>
                        <small>Informe senha da conta de email.</small>
                    </div>
                </fieldset>

                <fieldset class="content-group">
                    <legend class="text-bold">Termos de uso</legend>
                    <wysiwyg name="termos_uso" :rows="25" :texto="{{ json_encode($config->termos_uso) }}"></wysiwyg>
                </fieldset>
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
