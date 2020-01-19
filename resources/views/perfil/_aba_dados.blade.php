<div class="row">
    <div class="col-sm-12 col-md-5 col-lg-5">
        <div class="form-group">
            <label>Descrição:</label>
            <input autofocus type="text" class="form-control" name="nome" value="{{ old('nome', isset($perfil) ? $perfil->nome : '') }}" required>
        </div>
    </div>

    <div class="col-sm-6 col-md-2 col-lg-2">
        <div class="form-group">
            <label>Ativo:</label>
            <select name="ativo" class="form-control select2" required>
                <option value=""></option>
                <option value="1" {{ old('ativo', isset($perfil) ? $perfil->ativo : '') === 1 || !isset($perfil) ? 'selected' : '' }}>Sim</option>
                <option value="0" {{ old('ativo', isset($perfil) ? $perfil->ativo : '') === 0 ? 'selected' : '' }}>Não</option>
            </select>
        </div>
    </div>

    @if (isset($dependencias['unidadePreDefinida']))
    <input name="unidade_id" value="{{ $dependencias['unidadePreDefinida']->id }}" type="hidden" />
    @else
    <div class="col-sm-12 col-md-5 col-lg-5">
        <div class="form-group">
            <label>Unidade:</label>
            <select name="unidade_id" class="form-control select2" required>
                <option value=""></option>
                @foreach($dependencias['unidades'] as $unidade)
                    <option value="{{ $unidade->id }}" {{ old('unidade_id', isset($perfil) ? $perfil->unidade_id : '') == $unidade->id ? 'selected' : '' }}>{{ $unidade->descricao }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endif
</div>
