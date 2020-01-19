@if ($centro_distribuicao->created_at)
    <input type="hidden" name="id" value="{{ $centro_distribuicao->id }}"/>
@endif

<div class="tabbable">
    <div class="pull-right" style="margin-bottom: 10px">
        @include('partials.forms.botao_salvar', ['voltar' => 'centro_distribuicao.index'])
    </div>
    <ul class="nav nav-tabs nav-tabs-bottom">
        <li class="active"><a href="#dados-unidades" data-toggle="tab">Unidade Refência</a></li>
        <li><a href="#dados-gerais" data-toggle="tab">Dados gerais</a></li>
        <li><a href="#endereco" data-toggle="tab">Localização/Endereço</a></li>
        <li><a href="#controle" data-toggle="tab">Endereço de Estocagem</a></li>
    </ul>



    <div class="tab-content">
        <div class="tab-pane active" id="dados-unidades">
            @include('centro_distribuicao._aba_unidade_referencia')
        </div>

        <div class="tab-pane " id="dados-gerais">
            @include('centro_distribuicao._aba_dados_gerais')
        </div>

        <div class="tab-pane" id="endereco">
            @include('centro_distribuicao._aba_endereco')
        </div>

        <div class="tab-pane" id="controle">
            @include('centro_distribuicao._aba_deposito_alocacao')
        </div>
    </div>

</div>


