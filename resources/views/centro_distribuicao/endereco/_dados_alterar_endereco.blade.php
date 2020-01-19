<div class="col-lg-12" style="align-items: center">
    <input type="hidden" name="id" value="{{ isset($endereco)?$endereco->id: '' }}">
    <input type="hidden" name="url" value="{{ url()->previous() }}">
    <div class="col-lg-8">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Área:</label>
                    <input autofocus type="text" class="form-control" name="area" disabled
                           value="{{ old('rua', isset($endereco) ? $endereco->area : '') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Rua:</label>
                    <input autofocus type="text" class="form-control" name="rua" disabled
                           value="{{ old('rua', isset($endereco) ? $endereco->rua : '') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Módulo:</label>
                    <input autofocus type="text" class="form-control" name="modulo" disabled
                           value="{{ old('modulo', isset($endereco) ? $endereco->modulo : '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nível:</label>
                    <input autofocus type="text" class="form-control" name="nivel" disabled
                           value="{{ old('nivel', isset($endereco) ? $endereco->nivel : '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Vão:</label>
                    <input autofocus type="text" class="form-control" name="vao" disabled
                           value="{{ old('vao', isset($endereco) ? $endereco->vao : '') }}">
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <fieldset class="content-group">
                <legend class="text-bold">Detalhes do Endereço</legend>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Quantidade de Produtos Itens:</label>
                                <input autofocus type="text" class="form-control" name="produtos"
                                       value="{{ old('produtos', isset($endereco) ? $endereco->produtos : '') }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Quantidade de Caixas:</label>
                                <input autofocus type="text" class="form-control" name="caixas"
                                       value="{{ old('caixas', isset($endereco) ? $endereco->caixas : '') }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Quantidade de Paletes:</label>
                                <input autofocus type="text" class="form-control" name="paletes"
                                       value="{{ old('paletes', isset($endereco) ? $endereco->paletes : '') }}">
                            </div>
                        </div>
                    </div>

                </div>
            </fieldset>
        </div>
    </div>
    <div class="col-lg-4" style="text-align: center; padding-top: 27px">
        <button type="button" @click="showImage('img/mapa_estrutura.png')">
            <small>Estrutura Organizacional</small>
        <img src="{{ asset('img/mapa_estrutura.png') }}" alt="" width="300" height="300">
            <small>clique na imagem para visualizar</small>
        </button>
    </div>

</div>