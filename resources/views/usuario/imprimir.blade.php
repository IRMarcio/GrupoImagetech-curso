@extends('layouts.imprimir')

@section('conteudo')
    @include('usuario.listagem', ['imprimir' => true])
@endsection