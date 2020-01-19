@if ($centro_distribuicao->created_at)
    <input type="hidden" name="id" value="{{ $centro_distribuicao->id }}"/>
@endif

<div class="tabbable">
    <ul class="nav nav-tabs nav-tabs-bottom">
        <li class="active"><a href="#dados-gerais" data-toggle="tab">Dados gerais</a></li>
        <li><a href="#controle" data-toggle="tab">Endereço de Estocagem</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="dados-gerais">
            @include('centro_distribuicao.armazem._aba_dados_gerais')
        </div>

        {{-- temporários--}}
        <div class="tab-pane" id="controle">
            @include('centro_distribuicao._aba_deposito_alocacao')
        </div>
    </div>
</div>

@include('partials.forms.botao_salvar', ['voltar' => 'centro_distribuicao.index'])
