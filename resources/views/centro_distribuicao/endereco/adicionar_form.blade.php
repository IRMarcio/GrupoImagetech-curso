@include('partials.modals.modal_ajax')
<div class="tabbable">
    <ul class="nav nav-tabs nav-tabs-bottom">
        <li class="active"><a href="#dados-gerais" data-toggle="tab">Adicionar</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="dados-gerais">
            @include('centro_distribuicao.endereco._dados_adicionar_endereco')
        </div>
        <div class="tab-pane" id="dados-area">
            @include('centro_distribuicao.endereco._dados_adicionar_endereco_area')
        </div>
        <div class="tab-pane" id="dados-rua">
            @include('centro_distribuicao.endereco._dados_adicionar_endereco_rua')
        </div>
        <div class="tab-pane" id="dados-modulo">
            @include('centro_distribuicao.endereco._dados_adicionar_endereco_modulo')
        </div>
        <div class="tab-pane" id="dados-nivel">
            @include('centro_distribuicao.endereco._dados_adicionar_endereco_nivel')
        </div>
        <div class="tab-pane" id="dados-vao">
            @include('centro_distribuicao.endereco._dados_adicionar_endereco_vao')
        </div>
    </div>
</div>

@include('partials.forms.botao_salvar', ['voltar' => null])


