@section('js')
    @parent
    <script src="{{ asset('assets/js/modulos/carregasecoes.js') }}"></script>
@stop

<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label>Tipo de produto:</label>
            <select autofocus required name="tipo_produto_id" class="form-control select2">
                <option value=""></option>
                @foreach($tiposProdutos as $tipoProduto)
                    <option value="{{ $tipoProduto->id }}" {{ old('tipo_produto_id', isset($enderecamento) ? $enderecamento->tipo_produto_id : session('tipo_produto_id')) == $tipoProduto->id ? 'selected' : '' }}>{{ $tipoProduto->descricao }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if (!empty($dependencias['unidades']))
        <div class="col-lg-4">
            <div class="form-group">
                <label>Unidade:</label>
                <select name="unidade_id" class="form-control select2 carregar-secoes" data-target="secao_id" required>
                    <option></option>
                    @foreach($dependencias['unidades'] as $unidade)
                        <option value="{{ $unidade->id }}" {{ old('unidade_id', isset($enderecamento) ? $enderecamento->secao->unidade_id : session('unidade_id')) == $unidade->id ? 'selected' : '' }}>{{ $unidade->descricao }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
    <div class="col-lg-4">
        <div class="form-group">
            <label>Seção:</label>
            <select required name="secao_id" class="form-control select2">
                <option></option>
                @if (!empty($dependencias['secoes']))
                @foreach($dependencias['secoes'] as $secao)
                    <option value="{{ $secao->id }}" {{ old('secao_id', isset($enderecamento) ? $enderecamento->secao_id : session('secao_id')) == $secao->id ? 'selected' : '' }}>{{ $secao->descricao }}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-2">
        <div class="form-group">
            <label>Área:</label>
            <input type="text" maxlength="2" class="form-control" name="area" value="{{ old('area', isset($enderecamento) ? $enderecamento->area : '') }}" required>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label>Rua :</label>
            <input type="text" maxlength="2" class="form-control mask-inteiro" name="rua" value="{{ old('rua', isset($enderecamento) ? $enderecamento->rua : '') }}" required>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label>Módulo:</label>
            <input type="text" maxlength="3" class="form-control mask-inteiro" name="modulo" value="{{ old('modulo', isset($enderecamento) ? $enderecamento->modulo : '') }}" required>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label>Nível:</label>
            <input type="text" maxlength="2" class="form-control mask-inteiro" name="nivel" value="{{ old('nivel', isset($enderecamento) ? $enderecamento->nivel : '') }}" required>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label>Vão:</label>
            <input type="text" maxlength="1" class="form-control mask-inteiro" name="vao" value="{{ old('vao', isset($enderecamento) ? $enderecamento->vao : '') }}" required>
        </div>
    </div>
</div>

@include('partials.forms.botao_salvar', ['voltar' => 'enderecamento.index'])