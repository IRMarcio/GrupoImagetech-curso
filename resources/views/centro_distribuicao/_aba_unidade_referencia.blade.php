<fieldset class="content-group">
    <legend class="text-bold">Unidade Responsável</legend>

    <div class="panel panel-default">
        <div class="panel-body">Unidade/Responsável</div>
        <div class="form-group container-fluid">
            <select required name="unidade" class="form-control select2">
                <option value=""></option>
            @foreach($dependencias['unidades'] as $unidade)
                    <option value="{{ $unidade->id }}"
                            {{ old('unidade', !$centro_distribuicao->unidadeCentro->isEmpty() ? $centro_distribuicao->unidadeCentro->first()->id : session('unidade')) == $unidade->id ? 'selected' : '' }}>{{ $unidade->descricao }}</option>
                @endforeach
            </select>
        </div>
    </div>
</fieldset>


