<fieldset class="content-group">
    <legend class="text-bold">Identificação/Geral</legend>

    @include('centro_distribuicao._dados_gerais')
    @include('centro_distribuicao._dados_contato')
</fieldset>

<fieldset class="content-group">
    <legend class="text-bold">Endereço</legend>
    @include('centro_distribuicao.armazem._dados_endereco')
</fieldset>


@if($centro_distribuicao->endAlocacao->count()  == 0)
    <fieldset class="content-group">
        <legend class="text-bold">Estrutura de Organização de Alocação Depósito</legend>
        @include('centro_distribuicao._dados_endereco_alocacao')
    </fieldset>
@endif