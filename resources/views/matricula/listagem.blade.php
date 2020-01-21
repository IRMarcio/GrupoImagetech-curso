<table class="table table-striped">
    <thead>
    <tr>
        <th width="25%">Aluno</th>
        <th width="20%">Curso</th>
        <th>Período</th>
        <th>Turma</th>
        <th>Status</th>
        <th>Opçoes</th>
    </tr>
    </thead>
    <tbody data-link="row" class="rowlink">
    @forelse($dados as $registro)

        <tr>
            <td>
                {{ $registro->alunos->nome }}
            </td>
            <td>
                {{ $registro->centroCursos->first()->curso->nome }}
            </td>
            <td>
                {{ $registro->centroCursos->first()->periodo->descricao }}
            </td>
            <td>
                {{ formatarDataAno($registro->centroCursos->first()->data_inicio) }}
            </td>
            <td>
                {{ $registro->getStatus($registro->status) }}
            </td>

            @can(['matricula.alterar', 'matricula.excluir'])
                @if (!isset($imprimir))
                    <td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    @can('matricula.alterar')
                                        <li>
                                            <a href="{{ route('matricula.alterar', $registro) }}"><i class="icon-pencil3"></i> Editar</a>
                                        </li>
                                    @endcan

                                    @can('matricula.excluir')
                                        <li>
                                            <a href="{{ route('matricula.excluir', $registro) }}" class="confirma-acao" data-texto="Deseja mesmo excluir este registro?"><i class="icon-trash-alt"></i> Excluir</a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </td>
                @endif
            @endcan
        </tr>
    @empty
        <tr>
            <td colspan="99">Nenhum registro encontrado.</td>
        </tr>
    @endforelse
    </tbody>
</table>
