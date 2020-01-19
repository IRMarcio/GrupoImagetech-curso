@extends('layouts.imprimir')

@section('conteudo')
    @include('perfil.listagem', ['imprimir' => true])
@endsection