@extends('layouts.imprimir')

@section('conteudo')
    @include('estado.listagem', ['imprimir' => true])
@endsection
