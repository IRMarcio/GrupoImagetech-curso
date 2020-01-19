<div class="row">
    <div class="col-xs-4 col-sm-2 col-md-2 col-lg-2">
        <div class="form-group">
            <label>Estado:</label>
            <select required name="uf_id" class="form-control select2 carregar-municipios" data-target="municipio_id">
                <option value=""></option>
                @foreach($dependencias['estados'] as $estado)
                    <option value="{{ $estado->id }}" {{ old('uf_id', isset($unidade->municipio) ? $unidade->municipio->uf_id : session('uf_id')) == $estado->id ? 'selected' : '' }}>{{ $estado->uf }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-8 col-sm-6 col-md-6 col-lg-3">
        <div class="form-group">
            <label>Município:</label>
            <select required name="municipio_id" class="form-control select2 carregar-bairros-por-municipio" data-target="bairro_id">
                <option value=""></option>
                @if (isset($dependencias['municipios']))
                    @foreach($dependencias['municipios'] as $cidade)
                        <option value="{{ $cidade->id }}" {{ old('municipio_id', isset($unidade) ? $unidade->municipio_id : session('municipio_id')) == $cidade->id ? 'selected' : '' }}>{{ $cidade->descricao }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-sm-4 col-md-2 col-lg-2">
        <div class="form-group">
            <label>CEP:</label>
            <input type="text" class="form-control mask-cep" name="cep" value="{{ old('cep', isset($unidade) ? $unidade->cep : '') }}" maxlength="8">
        </div>
    </div>
    <div class="col-sm-12 col-md-5 col-lg-5">
        <div class="form-group">
            <label>Endereço:</label>
            <input type="text" class="form-control" name="endereco" value="{{ old('endereco', isset($unidade) ? $unidade->endereco : '') }}" maxlength="255">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group">
            <label>Bairro:</label>
            <input type="text" class="form-control" name="bairro" value="{{ old('bairro', isset($unidade) ? $unidade->bairro : '') }}" maxlength="255">
        </div>
    </div>
    <div class="col-sm-4 col-md-2 col-lg-2">
        <div class="form-group">
            <label>Número:</label>
            <input type="text" class="form-control" name="numero" value="{{ old('numero', isset($unidade) ? $unidade->numero : '') }}" maxlength="50">
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="form-group">
            <label>Complemento:</label>
            <input type="text" class="form-control" name="complemento" value="{{ old('complemento', isset($unidade) ? $unidade->complemento : '') }}" maxlength="150">
        </div>
    </div>
</div>
