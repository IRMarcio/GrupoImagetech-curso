@extends('layouts.imprimir')

@section('conteudo')
    @include('tipo_periodo.listagem', ['imprimir' => true])
@endsection
