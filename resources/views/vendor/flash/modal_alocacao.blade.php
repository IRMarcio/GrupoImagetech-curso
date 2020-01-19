<div class="modal fade centro-distribuicao-endereco" tabindex="-1" role="dialog" style="margin-top: 100px !important;">
    <div class="modal-xl center-block" role="document">
        <div class="modal-content">
            <div class="modal-header" style="    background: #273246;color: white;padding: 21px;">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true" style="color: white">×</span>
                </button>
                <h4 class="modal-title">Listagem de Carga do Endereço || @{{ endereco.area }}-@{{ endereco.rua }}-@{{ endereco.modulo }}-@{{ endereco.nivel }}-@{{ endereco.vao }}</h4>
            </div>
            <div class="modal-body">

                <div class="col-md-12">
                    <div class="col-sm-4 col-md-6 col-lg-4">
                        <div class="panel panel-body bg- has-bg-image" style="    background: rgba(39, 50, 70, 0.05);">
                            <div class="media no-margin">
                                <div class="media-body">
                                    <h3 class="no-margin" style="margin: -6px !important;"> @{{ qtd_produto_anterior }}</h3>
                                    <span class="text-uppercase text-size-mini">Quantidade de Produtos Entrada</span>
                                </div>

                                <div class="media-right media-middle">
                                    <img src="{{ asset('img/button_.png') }}" alt="" width="70" height="70">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-6 col-lg-4">
                        <div class="panel panel-body bg- has-bg-image" style="    background: rgba(39, 50, 70, 0.05);">
                            <div class="media no-margin">
                                <div class="media-body">
                                    <h3 class="no-margin" style="margin: -6px !important;"> @{{ qtdCaixas }}</h3>
                                    <span class="text-uppercase text-size-mini">Quantidade de Caixas</span>
                                </div>

                                <div class="media-right media-middle">
                                    <img src="{{ asset('img/button_.png') }}" alt="" width="70" height="70">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-6 col-lg-4">
                        <div class="panel panel-body bg- has-bg-image" style="    background: rgba(33, 226, 52, 0.06);">
                            <div class="media no-margin">
                                <div class="media-body">
                                    <h3 class="" style="margin: -6px !important;"> @{{ qtd_produto_atual }}</h3>
                                    <span class="text-uppercase text-size-mini">Quantidade Estocagem Atual</span>
                                </div>

                                <div class="media-right media-middle">
                                    <img src="{{ asset('img/button_1.png') }}" alt="" width="70" height="70">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="padding: 20px;background: rgb(232, 232, 232);">

                </div>

                <div class="">
                    <h4 for="title" style="margin-top: 120px">Lotes que se encontram estocados no endereço :</h4>

                    <table class="bordered table">
                        <tr>
                            <td>ID</td>
                            <td>CATMAT</td>
                            <td>Validade Lote</td>
                            <td>Descrição</td>
                            <td>Quantidade Atual</td>
                            <td>Unidade/fornecimento</td>
                            <td>Sustentável</td>
                        </tr>
                        <tbody>
                        <tr v-for="produto in produtos" :key="produto.id">
                            <td>@{{ produto.id  }}</td>
                            <td>@{{ produto.codigo  }}</td>
                            <td>@{{ moment(produto.data_validade_lote,'YYYY-MM-DD').format('DD/MM/YYYY') }}</td>
                            <td>@{{ produto.descricao  }}</td>
                            <td>@{{ produto.quantidade_atual  }}</td>
                            <td>@{{ produto.unidade_fornecimento  }}</td>
                            <td><span :class="produto._sustentavel === 'Sim' ? 'Livre': 'Ocupado'">@{{ produto._sustentavel  }}</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

