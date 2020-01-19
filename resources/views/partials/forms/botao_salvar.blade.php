<div class="text-left">
    <div class="btn-group">
        @if( !isset($salvar)|| isset($salvar) && $salvar)
            <button type="submit" name="acao" value="salvar" class="btn btn-primary">
                <i class="icon-database-check"></i>
                Salvar
            </button>
        @endif
    </div>
    <a href="{{ $voltar !== null ?route($voltar): url()->previous() }}" class="btn btn-default"><i class="icon-arrow-left5"></i> Voltar</a>
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
