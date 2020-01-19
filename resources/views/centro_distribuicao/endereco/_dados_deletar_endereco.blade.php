<div class="panel-content">
    <div class="panel-heading" style="    background: rgb(249, 249, 249);color: black;padding: 21px;">
        <input type="hidden" value="{{ route('enderecamento_cargas.endereco.delete') }}" id="rotaDelete">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
            <span aria-hidden="true" style="color: white">×</span>
        </button>
        <h4 class="modal-title">Endereço || @{{ endereco.area }}-@{{ endereco.rua }}-@{{
            endereco.modulo }}-@{{ endereco.nivel }}-@{{ endereco.vao }}</h4>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <div class="card" v-if="!deletar">
                <div class="card-header">
                    Impossível Remover Endereço
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0" >
                        <p>O Endereço @{{ endereco.area }}-@{{ endereco.rua }}-@{{endereco.modulo }}-@{{ endereco.nivel
                            }}-@{{ endereco.vao }},
                            possui @{{ produtos.length }} carga(s) alocada(s). É necessário transferir a carga para
                            outras alocações para prosseguir com a remoção.</p>
                        <footer class="blockquote-footer" style="background-color: rgba(255, 151, 127, 0.13);">Remoção
                            <cite title="Source Title"> do Endereço negada.</cite></footer>
                    </blockquote>
                </div>
            </div>
            <div class="card" v-else="!deletar">
                <div class="card-header">
                    Endereço em possibilidade de Remover
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0" style="padding:0px !important;padding-left: 10px !important;">
                        <p>O Endereço @{{ endereco.area }}-@{{ endereco.rua }}-@{{endereco.modulo }}-@{{ endereco.nivel
                            }}-@{{ endereco.vao }},</p>
                        <footer class="blockquote-footer"
                                style="background-color: rgba(127, 255, 212, 0.13);">Remoção <cite title="Source Title">
                                do Endereço Permitida.</cite></footer>
                    </blockquote>

                    <div class="col-lg-3 pull-right" style="margin-top: 20px !important;padding: 30px;    background: rgba(255, 245, 238, 0.43);">
                        <a href="#" v-on:click="execDeletar" class="btn btn-default  btn-block"
                           style="
                           /*background: rgba(244, 67, 54, 0.45);*/
                            color: black;
                            font-size: medium;
                            font-family: monospace;">EXCLUIR ENDEREÇO</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
