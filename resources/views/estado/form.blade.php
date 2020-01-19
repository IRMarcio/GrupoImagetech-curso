<div class="row">
    <div class="col-xs-8 col-sm-8 col-md-4 col-lg-8">
        <div class="form-group">
            <label>Descrição:</label>
            <input autofocus type="text" class="form-control" name="descricao" value="{{ old('descricao', isset($estado) ? $estado->descricao : '') }}" required>
        </div>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <label>Sigla:</label>
            <input type="text" class="form-control" name="uf" value="{{ old('uf', isset($estado) ? $estado->uf : '') }}" required maxlength="2">
        </div>
    </div>
</div>

@include('partials.forms.botao_salvar', ['voltar' => 'estado.index'])
