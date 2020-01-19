<template>
    <div>
        <span class="pull-left">@{{ parcial }}   --  Total Geral de lotes R$ @{{ somatoria }}</span>
        <button type="button" @click="adicionar" class="btn btn-default pull-right">
            Adicionar Lotes
        </button>
        <table class="table " width="100%">
            <tbody v-for="(lote, index) in lotes">
            <div class="row">
                <tr>
                    <th>Armaz. Tipo</th>
                    <th>Lote</th>
                    <th>Qtd. Caixas</th>
                    <th>Qtd. Total</th>
                    <th>Praz/Val Total</th>
                    <th>Fabricação</th>
                    <th>Validade</th>
                </tr>
                <tr>

                    <td style="padding: 0px" width="15%">
                        <select class="form-control" v-model.lazy="lote.tipo_armazenamento_id" style="width: 100%"
                                :name="'lotes['+ index +'][tipo_armazenamento_id]'" required>
                            <option value=""></option>
<!--                            @foreach($armazenamento as $key => $value)-->
<!--                            <option value="{{ $key }}">{{ $value }}</option>-->
<!--                            @endforeach-->
                        </select>
                    </td>
                    <td style="padding: 0px" width="10%">
                        <input class="form-control" type="text" v-model.lazy="lote.lote"
                               :name="'lotes['+ index +'][lote]'" required/>
                    </td>
                    <td style="padding: 0px" width="10%">
                        <input class="form-control" type="number"
                               v-on:blur="formqtdCaixas(index)"
                               v-model.lazy="lote.qtd_caixas"
                               :name="'lotes['+ index +'][qtd_caixas]'" required/>
                    </td>
                    <td style="padding: 0px" width="10%">
                        <input class="form-control" type="number" v-model.lazy="lote.qtd_total"
                               v-on:blur="somaValorTotal(index) "
                               :name="'lotes['+ index +'][qtd_total]'" required readonly/>
                    </td>
                    <td style="padding: 0px" width="10%">
                        <input class="form-control" type="number" v-model.lazy="lote.prazo_val_total"
                               :name="'lotes['+ index +'][prazo_val_total]'" required readonly/>
                    </td>
                    <td style="padding: 0px" width="10%">
                        <input class="form-control" type="date" v-model.lazy="lote.data_fabricacao"
                               v-on:blur="getFormula(index)"
                               :name="'lotes['+ index +'][data_fabricacao]'"
                               required/>
                    </td>
                    <td style="padding: 0px" width="10%">
                        <input class="form-control" type="date" v-model.lazy="lote.data_validade"
                               v-on:blur="getFormula(index)"
                               :name="'lotes['+ index +'][data_validade]'"
                               required/>
                    </td>
                </tr>
            </div>
            <div class="row">
                <tr>
                    <th>Data Entrega</th>
                    <th>Dias Trasnc.</th>
                    <th>Meses</th>
                    <th>%</th>
                    <th>Valor Unit.</th>
                    <th>Valor Total</th>
                    <th style="text-align: center">Ação</th>
                </tr>
                <tr>
                    <td style="padding: 0px" width="10%">
                        <input class="form-control" type="date" v-model.lazy="lote.data_entrega"
                               v-on:blur="getFormula(index)"
                               :name="'lotes['+ index +'][data_entrega]'"
                               required/>
                    </td>
                    <td style="padding: 0px" width="10%">
                        <input class="form-control" type="number" v-model.lazy="lote.numero_dias_transc"
                               :name="'lotes['+ index +'][numero_dias_transc]'" required readonly/>
                    </td>
                    <td style="padding: 0px" width="10%">
                        <input class="form-control" type="number" v-model.lazy="lote.numero_meses"
                               :name="'lotes['+ index +'][numero_meses]'" required readonly/>
                    </td>
                    <td style="padding: 0px" width="10%">
                        <input class="form-control" type="number" v-model.lazy="lote.porcetagem"
                               :name="'lotes['+ index +'][porcetagem]'" required readonly/>
                    </td>
                    <td style="padding: 0px" width="10%">
                        <input class="form-control" type="text" v-model.lazy="lote.valor_unitario"
                               v-on:blur="formqtdCaixas(index)" :change="formqtdCaixas(index)"
                               :name="'lotes['+ index +'][valor_unitario]'" required/>
                    </td>
                    <td style="padding: 0px" width="10%">
                        <input class="form-control" type="number" v-model.lazy="lote.valor_total"
                               :name="'lotes['+ index +'][valor_total]'" required readonly/>
                    </td>

                    <td>
                        <button type="button" @click="excluir(index)" title="Excluir"
                                class=" btn btn-default btn-block btn-sx" style="padding: 2px">
                            <i class="fa fa-trash"></i> Excluir
                        </button>
                    </td>
                </tr>
            </div>
            <tr>
                <td colspan="9999" style="background: #0c5460; padding: 1px !important;"></td>
            </tr>
            </tbody>
        </table>
        <br/>
    </div>
</template>


<script>
    export default {
        props: ['registros'],
        data() {
            return {
                somatoria: 0,
                parcial: '',
                lotes: [],
                money: {
                    decimal: ',',
                    thousands: '.',
                    prefix: 'R$ ',
                    suffix: ' #',
                    precision: 2,
                    masked: false
                },
                lote: {
                    tipo_armazenamento_id: null,
                    lote: null,
                    qtd_caixas: null,
                    qtd_total: null,
                    prazo_val_total: null,
                    data_fabricacao: null,
                    data_validade: null,
                    data_entrega: null,
                    numero_dias_transc: null,
                    numero_meses: null,
                    porcetagem: null,
                    valor_unitario: null,
                    valor_total: null
                }
            }
        },
        beforeMount() {
            lotes = this.registros || [];
            let self = this;
            lotes = lotes.map((lote) => {
                self.somatoria += lote.valor_total;
                console.log(new Intl.NumberFormat('de-DE', {
                    style: 'currency',
                    currency: 'EUR'
                }).format(self.somatoria));
                return {
                    tipo_armazenamento_id: lote.tipo_armazenamento_id,
                    lote: lote.lote,
                    qtd_caixas: lote.qtd_caixas,
                    qtd_total: lote.qtd_total,
                    prazo_val_total: lote.prazo_val_total,
                    data_fabricacao: lote.data_fabricacao,
                    data_validade: lote.data_validade,
                    data_entrega: lote.data_entrega,
                    numero_dias_transc: lote.numero_dias_transc,
                    numero_meses: lote.numero_meses,
                    porcetagem: lote.porcetagem,
                    valor_unitario: lote.valor_unitario,
                    valor_total: lote.valor_total
                }
            })

            this.lotes = lotes

            if (this.lotes.length === 0) {
                this.adicionar();
            }
        },
        methods: {
            somatoriaTotal() {
                let self = this;
                self.soma = 0;
                this.lotes.forEach(item => {
                    self.soma += item.valor_total;
                })
                self.somatoria = this.soma;
                self.parcial = $("#parcial option:selected").text();
            },
            formqtdCaixas(index) {
                item = this.lotes[index];
                soma = item.valor_unitario * item.qtd_total;
                this.lotes[index].valor_total = this.ajuste(soma, 3);
                this.lotes[index].qtd_total = item.qtd_caixas * 5;
                this.somatoriaTotal()
            },
            somaValorTotal(index) {
                item = this.lotes[index]
            },
            /**
             * Adiciona um novo lote para entrega de medicamentos.
             */
            adicionar() {
                this.lotes.push(Vue.util.extend({}, this.lote));
            },

            /**
             * Remove um lote de entrega de medicamentos.
             */
            excluir(index) {
                this.lotes.splice(index, 1);

                if (this.lotes.length === 0) {
                    this.adicionar();
                }
            },
            getFormula(index) {
                this.formDiasTransc(index)
                this.formValidadeTotal(index)
            },
            formValidadeTotal(index) {
                item = this.lotes[index];

                var dataInicio = new Date(item.data_fabricacao);
                var dataFim = new Date(item.data_validade);

                var diffMilissegundos = dataFim - dataInicio;
                var diffSegundos = diffMilissegundos / 1000;
                var diffMinutos = diffSegundos / 60;
                var diffHoras = diffMinutos / 60;
                var diffDias = diffHoras / 24;
                var diffMeses = diffDias / 30;

                this.lotes[index].prazo_val_total = Math.round(diffDias / 30);

            },
            formDiasTransc(index) {
                item = this.lotes[index];

                dataInicio = new Date(item.data_fabricacao);
                dataFim = new Date(item.data_entrega);

                diffMilissegundos = dataFim - dataInicio;
                diffSegundos = diffMilissegundos / 1000;
                diffMinutos = diffSegundos / 60;
                diffHoras = diffMinutos / 60;
                diffDias = diffHoras / 24;
                diffMeses = diffDias / 30;
                this.lotes[index].numero_dias_transc = Math.round(diffDias) - 1;
                this.lotes[index].numero_meses = (this.lotes[index].numero_dias_transc / 30).toFixed(2);
                _porcet = (this.lotes[index].numero_meses / this.lotes[index].prazo_val_total * 100)
                this.lotes[index].porcetagem = this.ajuste(_porcet, 2);
            },
            ajuste(nr, casas) {
                const og = Math.pow(10, casas);
                return Math.floor(nr * og) / og;
            }
        },
    }
</script>

<style scoped>

</style>