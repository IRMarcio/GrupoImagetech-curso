<div class="col-lg-12" style="align-items: center">
    <input type="hidden" name="id" value="{{ isset($endereco)?$endereco->id: '' }}">
    <input type="hidden" name="url" value="{{ url()->previous() }}">
    <div class="col-lg-10">
        <div class="row">
            <div class="col-md-3">

                <div class="form-group">
                    <label>Área:</label>
                    <select class="form-control" v-model="selecionado.area">
                        <option v-for="endereco in areas" :key="endereco.id" :value="endereco.area">@{{ endereco.area
                            }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Rua:</label>
                    <select class="form-control" v-model="selecionado.rua" :allow-empty="false">
                        <option v-for="endereco in ruas" :key="endereco.id" :value="endereco.rua">@{{ endereco.rua }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <fieldset class="content-group">
                <legend class="text-bold">Quantidade de Novas Alocações</legend>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Módulos:</label>
                                <input  type="number" class="form-control" v-model="obj_modulo.q_modulo" >
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Nível:</label>
                                <input  type="number" class="form-control" v-model="obj_modulo.q_nivel" >
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Vão:</label>
                                <input  type="number" class="form-control" v-model="obj_modulo.q_vao" >
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
