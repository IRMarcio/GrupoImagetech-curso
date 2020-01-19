<table class="table table-striped" width="100%">
    <thead>
    <tr>
        <th width="15%">Código</th>
        <th>Descrição</th>
        <th width="25%">Tipo de Período</th>
        <th width="15%">Atualizado em</th>
        @can(['periodo.alterar', 'periodo.excluir'])
            @if (!isset($imprimir))
                <th width="10%"></th>
            @endif
        @endcan
    </tr>
    </thead>
    <tbody data-link="row" class="rowlink">
    @forelse($dados as $registro)
        <tr>
            <td>{{ $registro->codigo }}</td>
            <td>{{ $registro->descricao }}</td>
            <td>{{ isset($registro->tipoPeriodo) ? $registro->tipoPeriodo->descricao : ' - ' }}</td>
            <td>
                {{ $registro->atualizado_em }}
            </td>

            @if(temAlgumaPermissao(['periodo.alterar', 'periodo.excluir']))
                @if (!isset($imprimir))
                    <td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    @can('periodo.alterar')
                                        <li>
                                            <a href="{{ route('periodo.alterar', $registro) }}"><i class="icon-pencil3"></i> Editar</a>
                                        </li>
                                    @endcan

                                    @can('periodo.excluir')
                                        <li>
                                            <a href="{{ route('periodo.excluir', $registro) }}" class="confirma-acao" data-texto="Deseja mesmo excluir este registro?"><i class="icon-trash-alt"></i> Excluir</a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </td>
                @endif
            @endif
        </tr>
    @empty
        <tr>
            <td colspan="99">Nenhum registro encontrado.</td>
        </tr>
    @endforelse
    </tbody>
</table>
