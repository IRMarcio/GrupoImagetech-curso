<div class="col-lg-12" style="align-items: center">
    <input type="hidden" name="id" value="{{ isset($endereco)?$endereco->id: '' }}">
    <input type="hidden" name="url" value="{{ url()->previous() }}">
    <div class="col-lg-10">
        <div class="col-lg-12">
            <fieldset class="content-group">
                <legend class="text-bold">Quantidade de Novas Alocações</legend>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>&Aacute;rea:</label>
                                <input  type="number" class="form-control" v-model="obj_area.q_area" >
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Rua:</label>
                                <input  type="number" class="form-control" v-model="obj_area.q_rua" >
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>M&oacute;dulos:</label>
                                <input  type="number" class="form-control" v-model="obj_area.q_modulo" >
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>N&iacute;vel:</label>
                                <input  type="number" class="form-control" v-model="obj_area.q_nivel" >
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>V&atilde;o:</label>
                                <input  type="number" class="form-control" v-model="obj_area.q_vao" >
                            </div>
                        </div>
                    </div>

                </div>
            </fieldset>
        </div>
    </div>

    <div class="col-lg-2" style="text-align: center; padding-top: 27px">
        <button type="button" @click="showImage('img/mapa_estrutura.png')">
            <small>Estrutura Organizacional</small>
            <img src="{{ asset('img/mapa_estrutura.png') }}" alt="" width="150" height="100">
            <small>clique na imagem para visualizar</small>
        </button>
    </div>

</div>
<div class="col-lg-12">
    <fieldset class="content-group">
        <legend class="text-bold"><a href="#dados-gerais" data-toggle="tab">Retornar Principal...</a></legend>
    </fieldset>
</div>
