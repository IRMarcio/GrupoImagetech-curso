@extends('layouts.imprimir')

@section('conteudo')
    @include('aluno.listagem', ['imprimir' => true])
@endsection
