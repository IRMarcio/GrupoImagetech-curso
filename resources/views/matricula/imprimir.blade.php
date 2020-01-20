@extends('layouts.imprimir')

@section('conteudo')
    @include('matricula.listagem', ['imprimir' => true])
@endsection
