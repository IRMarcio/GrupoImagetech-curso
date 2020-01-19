<button type="submit" name="acao" value="filtrar" class="btn btn-primary"><b><i class="icon-search4"></i></b> Buscar</button>

@isset($relatorio)
    <a target="_blank" href="{{ route( 'report', [$relatorio, $saida] ) }}" title="Imprimir" class="btn btn-default">
        <i class="icon-printer"></i>
    </a>
@endisset

@empty($relatorio)
	<a target="_blank" href="{{ request()->fullUrl() }}{{ strpos(request()->fullUrl(), '?') !== false ? '&' : '?' }}acao=imprimir&relformato=pdf" title="Imprimir" class="btn btn-default">
	    <i class="icon-printer"></i>
	</a>
@endempty

<a target="_blank" href="{{ request()->fullUrl() }}{{ strpos(request()->fullUrl(), '?') !== false ? '&' : '?' }}acao=imprimir&relformato=xls" title="Exportar" class="btn btn-default">
    <i class="icon-table"></i>
</a>