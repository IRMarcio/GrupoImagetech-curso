<div class="modal fade" tabindex="-1" role="dialog" id="flash-overlay-modal" style="margin-top: 100px !important;">
    <div class="modal-xl center-block" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title">PROCESSO : @{{ processo.codigo }}</h4>
            </div>
            <div class="modal-body">

                <div class="col-sm-4 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="title">Número do Processo:</label>
                        <input type="text" class="form-control" v-model="processo.codigo">
                    </div>
                </div>
                <div class="col-sm-4 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="title">NUP:</label>
                        <input type="text" class="form-control" v-model="processo.nup">
                    </div>
                </div>
                <div class="col-sm-4 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="title">Responsável:</label>
                        <input type="text" class="form-control" v-model="usuario.nome">
                    </div>
                </div>
                <div class="col-sm-4 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="title">Data de Início:</label>
                        <input type="text" class="form-control" v-model="processo.data_inicio">
                    </div>
                </div>
                <div class="col-sm-4 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="title">Data de Término:</label>
                        <input type="text" class="form-control" v-model="processo.data_fim">
                    </div>
                </div>
                <div class="col-sm-4 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="title">Forma de Contratação:</label>
                        <input type="text" class="form-control" v-model="contratacao.descricao">
                    </div>
                </div>
                <div class="col-sm-4 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="title">Departamento:</label>
                        <input type="text" class="form-control" v-model="departamento.descricao">
                    </div>
                </div>
                <div class="col-sm-4 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="title">Geral:</label>
                        <input type="text" class="form-control" v-model="geral.descricao">
                    </div>
                </div>

                <div class="">
                    <label for="title">Insumos:</label>

                    <table class="bordered table">
                        <tr>
                            <td>CATMAT</td>
                            <td >Descricao</td>
                            <td>Quantidade</td>
                            <td>Valor</td>
                            <td>Valor Estimado</td>
                            <td>Valor Total</td>
                        </tr>
                        <tbody>
                        <tr v-for="header in insumos">
                            <td>@{{header.codigo_produto}}</td>
                            <td >@{{header.descricao}}</td>
                            <td>@{{header.quantidade}}</td>
                            <td>@{{header.valor}}</td>
                            <td>@{{header.valor_estimado}}</td>
                            <td>@{{header.valor_total}}</td>
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

