@extends('layouts.imprimir')

@section('conteudo')
    @include('relatorios.listagem_endereco.listagem', ['imprimir' => true])
@endsection