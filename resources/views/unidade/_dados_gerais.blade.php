<div class="row">
    <div class="col-sm-12 col-md-5 col-lg-5">
        <div class="form-group">
            <label>Descrição:</label>
            <input autofocus type="text" class="form-control" name="descricao" value="{{ old('descricao', isset($unidade) ? $unidade->descricao : '') }}" required maxlength="150">
        </div>
    </div>
    <div class="col-sm-8 col-md-5 col-lg-5">
        <div class="form-group">
            <label>Responsável:</label>
            <input type="text" class="form-control" name="responsavel" value="{{ old('responsavel', isset($unidade) ? $unidade->responsavel : '') }}" required maxlength="200">
        </div>
    </div>
    <div class="col-sm-4 col-md-2 col-lg-2">
        <label class="display-block">Ativo</label>
        <select name="ativo" class="form-control select2" required>
            <option value="1" {{ old('ativo', isset($unidade) ? $unidade->ativo : '') !== 0 ? 'selected' : '' }}>Sim</option>
            <option value="0" {{ old('ativo', isset($unidade) ? $unidade->ativo : '') === 0 ? 'selected' : '' }}>Não</option>
        </select>
    </div>
</div>