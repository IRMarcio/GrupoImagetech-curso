@if (isset($viewRotas))
    <p class="content-group">
        Informe abaixo o que este perfil pode e não pode acessar no sistema.
    </p>
    {!! $viewRotas !!}
@else
    <div id="permissoes">
    </div>
@endif
<br>