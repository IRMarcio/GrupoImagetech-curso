<div class="row">
    <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
        <div class="form-group">
            <label>Código:</label>
            <input autofocus type="text" class="form-control" name="codigo" value="{{ old('codigo', isset($periodo) ? $periodo->codigo : '') }}" required>
        </div>
    </div>
    <div class="col-xs-8 col-sm-8 col-md-6 col-lg-6">
        <div class="form-group">
            <label>Descrição:</label>
            <input type="text" class="form-control" name="descricao" value="{{ old('descricao', isset($periodo) ? $periodo->descricao : '') }}" required>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <label>Tipo de produto:</label>
            <select name="tipo_periodo_id" class="form-control select2">
                <option value=""></option>
                @foreach($tipoPeriodos as $tipoPeriodo)
                    <option value="{{ $tipoPeriodo->id }}" {{ old('tipo_periodo_id', isset($periodo) ? $periodo->tipo_periodo_id : session('tipo_periodo_id')) == $tipoPeriodo->id ? 'selected' : '' }}>{{ $tipoPeriodo->descricao }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-4 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
            <label>Unidade de fornecimento:</label>
            <input type="text" class="form-control" name="unidade_fornecimento" value="{{ old('unidade_fornecimento', isset($periodo) ? $periodo->unidade_fornecimento : '') }}" required>
        </div>
    </div>
    <div class="col-sm-6 col-md-2 col-lg-2">
        <div class="form-group">
            <label>Sustentável:</label>
            <select name="sustentavel" class="form-control select2" required>
                <option value=""></option>
                <option value="1" {{ old('sustentavel', isset($periodo) ? $periodo->sustentavel : '') === true || !isset($periodo) ? 'selected' : '' }}>Sim</option>
                <option value="0" {{ old('sustentavel', isset($periodo) ? $periodo->sustentavel : '') === false ? 'selected' : '' }}>Não</option>
            </select>
        </div>
    </div>
</div>


@include('partials.forms.botao_salvar', ['voltar' => 'periodo.index'])
