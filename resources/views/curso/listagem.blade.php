<table class="table table-striped" width="100%">
    <thead>
    <tr>
        <th width="5%">Código</th>
        <th width="15%">Nome</th>
        <th width="20%">Descrição</th>
        <th width="10%">Mensalidade</th>
        <th width="10%">Matrícula</th>
        <th>Período</th>
        <th>Duração</th>
        <th width="15%">Atualizado em</th>
        @can(['curso.alterar', 'curso.excluir'])
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
            <td>{{ $registro->nome }}</td>
            <td>{{ $registro->descricao }}</td>
            <td>R$ {{ number_format(floatval($registro->valor_mensalidade),2) }}</td>
            <td>R$ {{ number_format( floatval($registro->valor_matricula),2) }}</td>
            <td>
                <ul>
                    @foreach($registro->tipoPeriodo($registro->tipo_periodo_id) as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </td>
            <td style="text-align: center">{{ $registro->duracao }}</td>
            <td>
                {{ $registro->atualizado_em }}
            </td>

            @if(temAlgumaPermissao(['curso.alterar', 'curso.excluir']))
                @if (!isset($imprimir))
                    <td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    @can('curso.alterar')
                                        <li>
                                            <a href="{{ route('curso.alterar', $registro) }}"><i class="icon-pencil3"></i> Editar</a>
                                        </li>
                                    @endcan

                                    @can('curso.excluir')
                                        <li>
                                            <a href="{{ route('curso.excluir', $registro) }}" class="confirma-acao" data-texto="Deseja mesmo excluir este registro?"><i class="icon-trash-alt"></i> Excluir</a>
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
