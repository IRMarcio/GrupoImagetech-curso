@extends('layouts.imprimir')

@section('conteudo')
    @include('relatorios.estoque.listagem', ['imprimir' => true])
@endsection