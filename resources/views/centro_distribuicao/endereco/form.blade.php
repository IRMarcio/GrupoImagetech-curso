@include('partials.modals.modal_ajax')
<div class="tabbable">
    <ul class="nav nav-tabs nav-tabs-bottom">
        <li class="active"><a href="#dados-gerais" data-toggle="tab">Dados Gerais</a></li>
        <li><a href="#endereco" data-toggle="tab">Estrutura de Carga || Transferência</a></li>
        <li><a href="#codigo" data-toggle="tab">C&oacute;digo Endereçamento</a></li>
        <li><a href="#delete" data-toggle="tab">Deletar Endereço de Alocação</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="dados-gerais">
            @include('centro_distribuicao.endereco._dados_alterar_endereco')
        </div>

        <div class="tab-pane" id="endereco">
            @include('centro_distribuicao.endereco._dados_alterar_carga')
        </div>
        <div class="tab-pane" id="codigo">
            @include('centro_distribuicao.endereco._dados_codigo')
        </div>

        <div class="tab-pane" id="delete">
            @include('centro_distribuicao.endereco._dados_deletar_endereco')
        </div>
    </div>
</div>

@include('partials.forms.botao_salvar', ['voltar' => null])


