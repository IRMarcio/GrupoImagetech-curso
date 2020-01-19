@if ($aluno->created_at)
    <input type="hidden" name="id" value="{{ $aluno->id }}"/>
@endif

<fieldset class="content-group">
    <legend class="text-bold">Identificação/Geral</legend>

    @include('aluno._dados_gerais')
    @include('aluno._dados_contato')
</fieldset>

<fieldset class="content-group">
    <legend class="text-bold">Endereço</legend>

    @include('aluno._dados_endereco')
</fieldset>

@include('partials.forms.botao_salvar', ['voltar' => 'aluno.index'])
