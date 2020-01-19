@component('mail::message')
# Recuperação de senha

Olá, {{ $nome }}.

Acabamos de receber uma solicitação para recuperação de senha no sistema {{ $sistema }}. Para recuperá-la, por favor clique no botão abaixo:

@component('mail::button', ['url' => $url, 'color' => 'blue'])
    Recuperar senha
@endcomponent

Nota: Este email irá expirar em 24 horas, após isso será necessário gerar novamente outra requisição de recuperação de senha.

Caso você não tenha solicitado a recuperação, não precisa tomar nenhuma ação: apenas ignore essa mensagem.
@endcomponent