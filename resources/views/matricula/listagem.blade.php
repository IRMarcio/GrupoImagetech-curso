<table class="table table-striped">
    <thead>
    <tr>
        <th width="65%">Centro Estudantil</th>
        <th width="10%">Curso</th>
        <th width="15%">Período</th>
        <th width="15%">Aluno</th>
        <th width="15%">Status</th>

    </tr>
    </thead>
    <tbody data-link="row" class="rowlink">
    @forelse($dados as $registro)
        <tr>
            <td>
                {{ $registro->centro->descricao }}
            </td>
            <td>
                {{ $registro->curso->nome }}
            </td>
            <td>
                {{ $registro->aluno->nome }}
            </td>
            <td>
                {{ $registro->aluno->status }}
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
