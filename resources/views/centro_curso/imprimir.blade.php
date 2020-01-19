@extends('layouts.imprimir')

@section('conteudo')
    @include('curso.listagem', ['imprimir' => true])
@endsection
