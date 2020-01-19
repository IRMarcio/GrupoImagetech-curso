<table class="table table-striped" width="100%">
    <thead>
    <tr>
        <th width="15%">Curso</th>
        <th width="10%">Período</th>
        <th width="15%">Quantidade de Vagas</th>
        <th width="15%">Quantidade Ocupada</th>
        <th width="15%">Atualizado em</th>
    </tr>
    </thead>
    <tbody data-link="row" class="rowlink">
    @forelse($dados as $registro)
        <tr>
            <td>{{ $registro->curso }}</td>
            <td>{{ $registro->periodo }}</td>
            <td>{{ $registro->quantidade_vaga }}</td>
            <td>0</td>
            <td>
                {{ $registro->atualizado_em }}
            </td>

            @if(temAlgumaPermissao(['centro_curso.alterar', 'centro_curso.excluir']))
                @if (!isset($imprimir))
                    <td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    @can('centro_curso.alterar')
                                        <li>
                                            <a href="{{ route('centro_curso.alterar', $registro) }}"><i class="icon-pencil3"></i> Editar</a>
                                        </li>
                                    @endcan

                                    @can('centro_curso.excluir')
                                        <li>
                                            <a href="{{ route('centro_curso.excluir', $registro) }}" class="confirma-acao" data-texto="Deseja mesmo excluir este registro?"><i class="icon-trash-alt"></i> Excluir</a>
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
