@if ($unidade->created_at)
    <input type="hidden" name="id" value="{{ $unidade->id }}"/>
@endif

<div class="tabbable">
    <ul class="nav nav-tabs nav-tabs-bottom">
        <li class="active"><a href="#dados-gerais" data-toggle="tab">Dados gerais</a></li>
        <li><a href="#secoes" data-toggle="tab">Seções</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="dados-gerais">
            @include('unidade._aba_dados_gerais')
        </div>

        <div class="tab-pane" id="secoes">
            @include('unidade._aba_secoes')
        </div>
    </div>
</div>

@include('partials.forms.botao_salvar', ['voltar' => 'unidade.index'])
