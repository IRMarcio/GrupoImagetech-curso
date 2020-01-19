<table class="table table-striped" width="100%">
    <thead>
    <tr>
        <th width="35%">Nome</th>
        <th width="20%">Cpf</th>
        <th width="10%">Rg</th>
        <th width="20%">Telefone</th>
        <th width="20%">Email</th>
        <th width="15%">Data de Nascimento</th>
        <th width="15%">Ativo</th>
        <th width="15%">Atualizado </th>
        @if (!isset($imprimir))
            @can(['aluno.alterar', 'aluno.excluir'])
                <th width="10%"></th>
            @endcan
        @endif
    </tr>
    </thead>
    <tbody data-link="row" class="rowlink">
    @forelse($dados as $registro)
        <tr>

            <td>{{ $registro->nome }}</td>
            <td>{{ formatarCpf($registro->cpf) }}</td>
            <td>{{ $registro->rg }}</td>
            <td>{{ $registro->telefone }}</td>
            <td>{{ $registro->email }}</td>
            <td>{{ formatarData($registro->dt_nascimento) }}</td>
            <td>{{ $registro->ativo ? 'Sim' : 'Não' }}</td>
            <td>
                {{ $registro->atualizado_em }}
            </td>

            @if(temAlgumaPermissao(['aluno.alterar', 'aluno.excluir']))
                @if (!isset($imprimir))
                    <td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    @can('aluno.alterar')
                                        <li>
                                            <a href="{{ route('aluno.alterar', $registro) }}"><i class="icon-pencil3"></i> Editar</a>
                                        </li>
                                    @endcan

                                    @can('aluno.excluir')
                                        <li>
                                            <a href="{{ route('aluno.excluir', $registro) }}" v-confirma-exclusao><i class="icon-trash-alt"></i> Excluir</a>
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
