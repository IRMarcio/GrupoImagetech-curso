@extends('layouts.imprimir')

@section('conteudo')
    @include('unidade.listagem', ['imprimir' => true])
@endsection
