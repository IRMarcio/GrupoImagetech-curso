<table class="table table-striped" width="100%">
    <thead>
    <tr>
        @if (!isset($checkbox) || isset($checkbox) && $checkbox == true)
            <th width="5%">
                <input type="checkbox" class="styled selecionar-todos-registros" data-target="ids[]">
            </th>
        @endif
        <th width="5%">ID</th>
        <th width="25%">Ação</th>
        <th width="20%">Tipo</th>
        <th width="20%">Responsável</th>
        <th width="20%">Data</th>
        @if (!isset($imprimir))
            @can('auditoria.visualizar')
                <th width="10%"></th>
            @endcan
        @endif
    </tr>
    </thead>
    <tbody data-link="row" class="rowlink">
    @forelse($dados as $registro)
        <tr>
            @if (!isset($checkbox) || isset($checkbox) && $checkbox == true)
                <td class="table-inbox-checkbox rowlink-skip">
                    <input type="checkbox" class="styled" name="ids[]" value="{{ $registro->id }}">
                </td>
            @endif
            <td>{{ $registro->id }}</td>
            <td>{{ $registro->descricao_acao }}</td>
            <td>{{ $registro->tipo->descricao }}</td>
            <td>{{ $registro->usuario->nome }}</td>
            <td>{{ formatarData($registro->created_at, 'd/m/Y \à\s H:i') }}</td>
            @if (!isset($imprimir))
                @can('auditoria.visualizar')
                    <td class="text-center">
                        <a href="{{ route('auditoria.visualizar', $registro) }}" class="btn btn-xs btn-default" title="Visualizar">
                            <i class="icon-list"></i>
                            Detalhes
                        </a>
                    </td>
                @endcan
            @endif
        </tr>
    @empty
        <tr>
            <td colspan="99">Nenhum registro encontrado.</td>
        </tr>
    @endforelse
    </tbody>
</table>
