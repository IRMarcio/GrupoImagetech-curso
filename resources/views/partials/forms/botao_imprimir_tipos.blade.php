<div class="text-left">
    <div class="btn-group">
        <button type="submit" name="acao" value="imprimir" class="btn btn-primary">
            <i class="icon-printer"></i>
            Imprimir
        </button>
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Visualizar</span>
        </button>
        <ul class="dropdown-menu">
            <li>
                <button type="submit" name="acao" value="imprimir" class="btn">
                    <i class="icon-printer"></i>
                    PDF
                </button>
            </li>
        </ul>
    </div>
    <a href="{{ route($voltar) }}" class="btn btn-default"><i class="icon-arrow-left5"></i> Voltar</a>
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
