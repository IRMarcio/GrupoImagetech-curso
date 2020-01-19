@extends('layouts.default')

@section('titulo_pagina', 'Alterar Armazens')

@section('breadcrumbs')
    <li><a href="{{ route('centro_distribuicao.index') }}">Armazens</a></li>
    <li class="active">Alterar</li>
@endsection

@section('js')
    @parent
    <script src="{{ asset('assets/js/modulos/carregamunicipios.js') }}"></script>
@stop

@section('vue-componentes')
    <script src="{{ asset('assets/js/modulos/centro_distribuicao/form.js') }}"></script>
    <script src="{{ asset('assets/js/modulos/centro_distribuicao/armazem.js') }}"></script>
@stop

@section('conteudo')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form-us inline-template>
                <form action="{{ route('centro_distribuicao.alterar_armazens.post', [$centro_distribuicao->id, $centro_distribuicao->centro_distribuicao_id]) }}" method="POST" class="form-validate"  @submit="salvar">
                    @include('centro_distribuicao.armazem.formAlterar')
            </form-us>
        </div>
    </div>
@endsection
