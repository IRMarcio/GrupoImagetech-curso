@section('js')
    @parent
    <script src="{{ asset('assets/js/modulos/municipio/form.js') }}"></script>
@stop

<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-4">
        <div class="form-group">
            <label>Descrição:</label>
            <input autofocus type="text" class="form-control" name="descricao" value="{{ old('descricao', isset($municipio) ? $municipio->descricao : '') }}" required>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <label>Estado:</label>
            <select name="uf_id" class="form-control select2" required>
                <option value=""></option>
                @foreach($estados as $estado)
                    <option value="{{ $estado->id }}" {{ old('uf_id', isset($municipio) ? $municipio->uf_id : session('uf_id')) == $estado->id ? 'selected' : '' }}>{{ $estado->uf }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <label>CEP:</label>
            <input type="text" class="form-control mask-cep" name="cep" {{ isset($municipio) && $municipio->ind_cep_unico ? '' : 'readonly' }} value="{{ old('cep', isset($municipio) ? $municipio->cep : '') }}">
        </div>
    </div>
    <div class="col-sm-4 col-md-2 col-lg-2">
        <div class="form-group">
            <label class="display-block">&nbsp;</label>
            <label class="checkbox-inline">
                <div class="checker">
                    <input type="hidden" name="ind_cep_unico" value="0"/>
                    <input type="checkbox" class="styled" name="ind_cep_unico" value="1" {{ old('ind_cep_unico', isset($municipio) && $municipio->ind_cep_unico == 1 ? 'checked' : '') }} />
                </div>
                CEP único
            </label>
        </div>
    </div>
</div>

@include('partials.forms.botao_salvar', ['voltar' => 'municipio.index'])
