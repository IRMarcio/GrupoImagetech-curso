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
            <div class="col-md-3">
                <div class="form-group">
                    <label>Módulo:</label>
                    <select class="form-control" v-model="selecionado.modulo" :allow-empty="false">
                        <option v-for="endereco in modulos" :key="endereco.id" :value="endereco.modulo">@{{
                            endereco.modulo }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Nível:</label>
                    <select class="form-control" v-model="selecionado.nivel" :allow-empty="false">
                        <option v-for="endereco in niveis" :key="endereco.id" :value="endereco.nivel">@{{ endereco.nivel
                            }}
                        </option>
                    </select>
                </div>
            </div>

        </div>
        <div class="col-lg-12">
            <fieldset class="content-group">
                <legend class="text-bold">Quantidade de Novas Aloca&ccedil;&otilde;es</legend>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>V&atilde;o:</label>
                                <input type="number" class="form-control" v-model="obj_vao.q_vao">
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