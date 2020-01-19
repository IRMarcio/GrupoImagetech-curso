@extends('layouts.blank')

@section('titulo_pagina', 'Concordância com os termos de uso - ' . env('APP_NAME'))

@section('vue-componentes')
    <script src="{{ asset('assets/js/modulos/termo_uso/aceite.js') }}"></script>
@stop

@section('conteudo')
    <div class="page-container">
        <div class="page-content">
            <div class="content-wrapper">
                <div style="margin: 0 auto; width: 1024px;">
                    <div class="well">
                        <div class="pull left">
                            <h1>Termos de Uso</h1>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('logout') }}">
                                <i class="icon-switch2"></i>
                                Logout
                            </a>
                        </div>
                        <p class="text-muted">Leia todos os termos e condições abaixo antes de confirmar a aceitação.</p>
                    </div>
                    
                    <br />
                    <br />
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-body panel-body-accent">
                                {!! $termosUso !!}

                                <hr />
                                
                                <aceite inline-template>
                                    <form action="{{ route('termos_uso.aceite.post') }}" method="POST" class="form-validate">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" 
                                                                v-model="concordo_termos"
                                                                class="styled required"
                                                                name="concordo_termos"
                                                                value="1"
                                                            />
                                                            <span class="texto-checkbox">Li e estou de acordo com os termos de uso</span>    
                                                        </label>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group"> 
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" :disabled="!concordo_termos" class="btn btn-primary">Enviar</button>
                                                </div>
                                            </div>
                                        </div>
                                    <form>
                                </aceite>
                            </div>
                        </div>
                    </div>

                    <small>{{ config('sistema.titulo') }} - {{ config('sistema.fornecedor') }} - {{ config('sistema.versao') }}</small>
                </div>
            </div>
        </div>
    </div>
@endsection
