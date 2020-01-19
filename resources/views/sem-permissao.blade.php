@extends('layouts.default')


@section('titulo_pagina', 'Sem permissão')

@section('conteudo')
    <article>
        <h1>
            Sem permissão
            @if (isset($exception))
                (err: {{ $exception->getStatusCode() }})
            @endif
        </h1>
        <div>
            <p>Para acessar essa página e/ou realizar essa ação, é necessário ter permissões que o seu usuário não tem. Se acredita que isso é um erro, por favor, contate o suporte técnico.</p>
            <p>&mdash; Suporte</p>
        </div>
    </article>
@endsection
