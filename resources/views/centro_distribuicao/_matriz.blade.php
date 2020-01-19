<div class="col-sm-4 col-md-4 col-lg-4">
    <label class="display-block">Definir Como Matriz</label>
    <select name="matriz" class="form-control select2" required>
        <option value="1" {{ old('matriz', isset($centro_distribuicao) ? $centro_distribuicao->matriz : '') !== 0 ? 'selected' : '' }}>
            Sim
        </option>
        <option value="0" {{ old('matriz', isset($centro_distribuicao) ? $centro_distribuicao->matriz : '') === 0 ? 'selected' : '' }}>
            Não
        </option>
    </select>
</div>
