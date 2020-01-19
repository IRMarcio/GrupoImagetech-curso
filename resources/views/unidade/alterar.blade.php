@extends('layouts.default')

@section('titulo_pagina', 'Alterar Unidade')

@section('breadcrumbs')
    <li><a href="{{ route('unidade.index') }}">Unidades</a></li>
    <li class="active">Alterar</li>
@endsection

@section('js')
    @parent
    <script src="{{ asset('assets/js/modulos/carregamunicipios.js') }}"></script>
@stop

@section('vue-componentes')
    <script src="{{ asset('assets/js/modulos/unidade/form.js') }}"></script>
    <script src="{{ asset('assets/js/modulos/unidade/secao.js') }}"></script>
@stop

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form-us inline-template>
                <form action="{{ route('unidade.alterar.post', $unidade) }}" method="POST" class="form-validate" @submit="salvar">
                    @include('unidade.form')
                </form>
            </form-us>
        </div>
    </div>
@endsection
