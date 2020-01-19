@extends('layouts.imprimir')

@section('conteudo')
    @include('enderecamento.listagem', ['imprimir' => true])
@endsection
