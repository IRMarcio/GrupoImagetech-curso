<div class="col-sm-4 col-md-2 col-lg-2">
    <div class="form-group">
        <label for="">Código:</label>
        <input @keydown.13.prevent="{{ $filtrar }}" type="text" class="form-control" name="codigo_catmat" v-model="filtros.codigo_catmat">
    </div>
</div>
<div class="col-sm-4 col-md-4 col-lg-4">
    <div class="form-group">
        <label for="">Produto:</label>
        <input @keydown.13.prevent="{{ $filtrar }}" type="text" class="form-control" name="descricao_produto" v-model="filtros.descricao_produto">
    </div>
</div>
<div class="col-sm-4 col-md-2 col-lg-2">
    <div class="form-group">
        <label for="">Data de validade:</label>
        <input @keydown.13.prevent="{{ $filtrar }}" type="text" class="form-control mask-date" name="data_validade" v-model="filtros.data_validade">
    </div>
</div>
<div class="col-sm-4 col-md-4 col-lg-4">
    <label>&nbsp;</label>
    <div class="form-group">
        <a href="#" class="btn btn-default" @click.prevent="{{ $filtrar }}">
            <i class="icon-search4 position-left"></i> Filtrar
        </a>

        <a href="#" class="btn btn-default" @click.prevent="limparFiltros">
            <i class="icon-reset position-left"></i> Limpar filtros
        </a>
    </div>
</div>
