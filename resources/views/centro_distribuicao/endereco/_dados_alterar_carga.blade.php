        <div class="panel-content">
            <div class="panel-heading" style="    background: rgb(249, 249, 249);color: black;padding: 21px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true" style="color: white">×</span>
                </button>
                <h4 class="modal-title">Listagem de Carga do Endereço || @{{ endereco.area }}-@{{ endereco.rua }}-@{{
                    endereco.modulo }}-@{{ endereco.nivel }}-@{{ endereco.vao }}</h4>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-sm-4 col-md-6 col-lg-4">
                        <div class="panel panel-body bg- has-bg-image" style="    background: rgba(39, 50, 70, 0.05);">
                            <div class="media no-margin">
                                <div class="media-body">
                                    <h3 class="no-margin" style="margin: -6px !important;color: black;"> @{{ qtd_produto_anterior
                                        }}</h3>
                                    <span class="text-uppercase text-size-mini">Quantidade de Produtos Entrada</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-6 col-lg-4">
                        <div class="panel panel-body bg- has-bg-image" style="    background: rgba(39, 50, 70, 0.05);">
                            <div class="media no-margin">
                                <div class="media-body">
                                    <h3 class="no-margin" style="margin: -6px !important;color: black;"> @{{ qtdCaixas }}</h3>
                                    <span class="text-uppercase text-size-mini">Quantidade de Caixas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-6 col-lg-4">
                        <div class="panel panel-body bg- has-bg-image" style="    background: rgba(33, 226, 52, 0.06);">
                            <div class="media no-margin">
                                <div class="media-body">
                                    <h3 class="" style="margin: -6px !important;color: black;"> @{{ qtd_produto_atual }}</h3>
                                    <span class="text-uppercase text-size-mini">Quantidade Estocagem Atual</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="padding: 20px;background: rgb(249, 249, 249);">
                    </div>
                </div>
                <div class="col-lg-12">
                        <h4 for="title">Lotes que se encontram estocados no endere&ccedil;o aptos para Transfer&ecirc;ncias:</h4>
                    <table class="bordered table">
                        <tr>
                            <td>CATMAT</td>
                            <td>Validade Lote</td>
                            <td>Descrição</td>
                            <td>Quantidade Atual</td>
                            <th>Transferência</th>
                            <th>Ação</th>
                        </tr>
                        <tbody>
                        <tr v-for="produto in produtos" :key="produto.id">
                            <td>@{{ produto.codigo }}</td>
                            <td>@{{ moment(produto.data_validade_lote,'YYYY-MM-DD').format('DD/MM/YYYY') }}</td>
                            <td>@{{ produto.descricao }}</td>
                            <td>@{{ produto.quantidade_atual }}</td>
                            <td>
                                <input type="number" name="qnt" class="form-control"
                                       v-model="produto.quantidade_selecionada">
                            </td>
                            <td>
                                <a href="#" @click.prevent="selecionarProduto(produto)"
                                   class="btn btn-default"><i class="fa fa-check"></i></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr>

            <table class="table">
                <thead>
                <tr>
                    <td>CATMAT</td>
                    <td>Validade Lote</td>
                    <td>Descrição</td>
                    <td>Quantidade Selecionada</td>
                    <th width="30%">RE-Alocação</th>
                    <th width="10%">Remover</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(registro, index) in estocagem">
                    <td>@{{ registro.codigo }}</td>
                    <td>@{{ moment(registro.data_validade_lote,'YYYY-MM-DD').format('DD/MM/YYYY') }}</td>
                    <td>@{{ registro.descricao }}</td>
                    <td>@{{ registro.quantidade_selecionada }}</td>
                    <td>
                        <select name="alocacoes[]" v-model="registro.re_alocacao" required
                                v-select="registro.alocacao" style="width: 300px !important;">
                            <option v-for="alocacao in enderecos" :value="alocacao.id">
                                [ @{{ alocacao.area }}-@{{ alocacao.rua }}-@{{ alocacao.modulo }}-@{{ alocacao.nivel }}-@{{ alocacao.vao }} ]
                                @{{ alocacao.total_carga }}
                            </option>
                        </select>
                    </td>
                    <td>
                        <a href="#" @click.prevent="removerDaEstocagem(registro, index)"
                           class="btn btn-default"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                <tr v-show="estocagem.length == 0">
                    <td colspan="99">Nenhum produto selecionado</td>
                </tr>
                </tbody>
            </table>
            <input type="hidden" name="estocagens" :value="JSON.stringify(estocagem)">

        </div>

