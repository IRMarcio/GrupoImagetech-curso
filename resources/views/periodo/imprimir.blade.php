@extends('layouts.imprimir')

@section('conteudo')
    @include('periodo.listagem', ['imprimir' => true])
@endsection
