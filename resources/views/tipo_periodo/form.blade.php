<div class="row">
    <div class="col-xs-8 col-sm-8 col-md-4 col-lg-8">
        <div class="form-group">
            <label>Descrição:</label>
            <input autofocus type="text" class="form-control" name="descricao" value="{{ old('descricao', isset($tipoPeriodo) ? $tipoPeriodo->descricao : '') }}" required>
        </div>
    </div>
    <div class="col-sm-6 col-md-2 col-lg-2">
        <div class="form-group">
            <label>Ativo:</label>
            <select name="ativo" class="form-control select2" required>
                <option value=""></option>
                <option value="1" {{ old('ativo', isset($tipoPeriodo) ? $tipoPeriodo->ativo : '') === true || !isset($tipoPeriodo) ? 'selected' : '' }}>Sim</option>
                <option value="0" {{ old('ativo', isset($tipoPeriodo) ? $tipoPeriodo->ativo : '') === false ? 'selected' : '' }}>Não</option>
            </select>
        </div>
    </div>
    <div class="col-sm-6 col-md-2 col-lg-2">
        <div class="form-group">
            <label>Permanente:</label>
            <select name="permanente" class="form-control select2" required>
                <option value=""></option>
                <option value="1" {{ old('permanente', isset($tipoPeriodo) ? $tipoPeriodo->permanente : '') === true || !isset($tipoPeriodo) ? 'selected' : '' }}>Sim</option>
                <option value="0" {{ old('permanente', isset($tipoPeriodo) ? $tipoPeriodo->permanente : '') === false ? 'selected' : '' }}>Não</option>
            </select>
        </div>
    </div>
</div>

@include('partials.forms.botao_salvar', ['voltar' => 'tipo_periodo.index'])
