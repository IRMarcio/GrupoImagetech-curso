@extends('layouts.imprimir')

@section('conteudo')
    @include('municipio.listagem', ['imprimir' => true])
@endsection
