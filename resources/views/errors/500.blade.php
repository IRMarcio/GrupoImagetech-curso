@extends('layouts.default')

@section('titulo_pagina', 'Erro no servidor')

@section('conteudo')
    <article>
        <h1>
            Parece que houve um erro!
            @if (isset($exception))
                (err: {{ $exception->getStatusCode() }})
            @endif
        </h1>
        <div>
            @if (isset($exception))
                <p>(mensagem: {{ $exception->getMessage() }})</p>
            @endif
            <p>Alguma ação sua retornou um erro no servidor. Pedimos que entre em contato com o suporte técnico para resolver o problema.</p>
            <p>&mdash; Suporte</p>
        </div>
    </article>
@endsection
