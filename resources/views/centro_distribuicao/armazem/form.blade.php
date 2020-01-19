@if ($centro_distribuicao->created_at)
    <input type="hidden" name="id" value="{{ $centro_distribuicao->id }}"/>
@endif

<div class="tabbable">
    <ul class="nav nav-tabs nav-tabs-bottom">
        <li class="active"><a href="#dados-gerais" data-toggle="tab">Dados gerais</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="dados-gerais">
            @include('centro_distribuicao.armazem._aba_dados_gerais')
        </div>
    </div>
</div>

@include('partials.forms.botao_salvar', ['voltar' => 'centro_distribuicao.index'])
