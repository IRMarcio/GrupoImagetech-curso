<div class="row">
    <div class="col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <label for="cpf">CPF:</label>
            <input autofocus type="text" class="form-control mask-cpf text-right" data-rule-cpf="true" name="cpf" value="{{ old('cpf', isset($registro) ? $registro->cpf : '') }}" required/>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="form-group">
            <label for="nome">Nome completo:</label>
            <input type="text" class="form-control" name="nome" value="{{ old('nome', isset($registro) ? $registro->nome : '') }}" maxlength="200" required/>
        </div>
    </div>
    <div class="col-sm-6 col-md-4 col-lg-2">
        <div class="form-group">
            <label class="display-block" for="data_nascimento">Data de nascimento:</label>
            <input type="text" class="form-control mask-date text-right" data-rule-data="true" name="data_nascimento" value="{{ old('data_nascimento', isset($registro) ? formatarData($registro->data_nascimento, 'd/m/Y') : '') }}" required/>
        </div>
    </div>

    @if (auth()->user()->super_admin || auth()->user()->gestor)
    <div class="col-sm-4 col-md-2 col-lg-2">
        <label class="display-block">Gestor</label>
        <select name="gestor" class="form-control select2" required>
            <option value="1" {{ old('gestor', isset($registro) ? $registro->gestor : '') !== 0 ? 'selected' : '' }}>Sim</option>
            <option value="0" {{ old('gestor', isset($registro) ? $registro->gestor : '') === 0 ? 'selected' : '' }}>Não</option>
        </select>
    </div>
    @endif
</div>