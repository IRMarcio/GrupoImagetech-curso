@extends('layouts.imprimir')

@section('conteudo')
    @include('auditoria.listagem', ['imprimir' => true, 'checkbox' => false])
@endsection