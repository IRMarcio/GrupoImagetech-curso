<div class="row">
    <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
        <div class="form-group">
            <label>Código:</label>
            <input autofocus type="text" class="form-control" name="codigo" value="{{ old('codigo', isset($curso) ? $curso->codigo : '') }}" required>
        </div>
    </div>
    <div class="col-xs-8 col-sm-8 col-md-6 col-lg-6">
        <div class="form-group">
            <label>Nome:</label>
            <input type="text" class="form-control" name="nome" value="{{ old('nome', isset($curso) ? $curso->nome : '') }}" required>
        </div>
    </div>
    <div class="col-xs-8 col-sm-8 col-md-6 col-lg-4">
        <div class="form-group">
            <label>Descrição:</label>
            <input type="text" class="form-control" name="descricao" value="{{ old('descricao', isset($curso) ? $curso->descricao : '') }}" required>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <label>Período:</label>
            <select name="tipo_periodo_id[]" class="form-control select2" multiple>
                <option value=""></option>
                @foreach($tipoPeriodos as $tipoPeriodo)
                    <option value="{{ $tipoPeriodo->id }}" {{ isset($curso) ? collect(json_decode($curso->tipo_periodo_id))->contains($tipoPeriodo->id) ? "selected" : '': '' }} >{{ $tipoPeriodo->descricao }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <label>Duração:</label>
            <input class="form-control" type="number"  name="duracao" value="{{ old('duracao', isset($curso) ? $curso->duracao : '') }}" required>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <label>Valor Mensalidade:</label>
            <input class="form-control mask-money"   type="text"  name="valor_mensalidade" value="{{ old('valor_mensalidade', isset($curso) ? $curso->valor_mensalidade : '') }}" required>
        </div>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <label>Valor Matrícula:</label>
            <input class="form-control mask-money"   type="text"  name="valor_matricula" value="{{ old('valor_matricula', isset($curso) ? $curso->valor_matricula : '') }}" required>
        </div>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <label>Ativo:</label>
            <select name="ativo" class="form-control select2" required>
                <option value=""></option>
                <option value="1" {{ old('ativo', isset($curso) ? $curso->ativo : '') === true || !isset($curso) ? 'selected' : '' }}>Sim</option>
                <option value="0" {{ old('ativo', isset($curso) ? $curso->ativo : '') === false ? 'selected' : '' }}>Não</option>
            </select>
        </div>
    </div>
</div>


@include('partials.forms.botao_salvar', ['voltar' => 'curso.index'])
