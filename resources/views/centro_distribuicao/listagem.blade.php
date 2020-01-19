<table class="table table-striped" width="100%">
    <thead>
    <tr>
        <th width="">Descrição</th>
        <th width="20%">Município</th>
        <th width="10%">Ativo</th>
        <th width="10%">Escala</th>
        <th width="15%">Atualizado em</th>
        @if (!isset($imprimir))
            @can(['centro_distribuicao.alterar', 'centro_distribuicao.excluir'])
                <th width="10%"></th>
            @endcan
        @endif
    </tr>
    </thead>
    <tbody data-link="row" class="rowlink">
    @forelse($dados as $registro)
        <tr>
            <td>{{ $registro->descricao }}</td>
            <td>{{ $registro->endereco ? ($registro->endereco->municipio->descricao . '/' . $registro->endereco->municipio->uf->uf) : '' }}</td>
            <td>{{ $registro->ativo ? 'Sim' : 'Não' }}</td>
            <td> <span class="{{ $registro->matriz ? 'matriz': 'filial' }}"> {{ $registro->matriz ? 'MATRIZ' : 'FILIAL' }}</span></td>
            <td>
                {{ $registro->atualizado_em }}
            </td>

            @if(temAlgumaPermissao(['centro_distribuicao.alterar', 'centro_distribuicao.excluir']))
                @if (!isset($imprimir))
                    <td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right">

                                    @can('centro_distribuicao.alterar')
                                        <li>
                                            <a href="{{ route('centro_distribuicao.alterar', $registro) }}"><i class="icon-pencil3"></i> Editar</a>
                                        </li>
                                    @endcan

                                    @can('centro_distribuicao.alterar')
                                        <li>
                                            <a href="{{ route('centro_distribuicao.alterar', $registro) }}#controle"><i class="icon-grid"></i>Endereços/Estoque CD</a>
                                        </li>
                                    @endcan


                                    @can('centro_distribuicao.excluir')
                                        <li>
                                            <a href="{{ route('centro_distribuicao.excluir', $registro) }}" v-confirma-exclusao><i class="icon-trash-alt"></i> Excluir</a>
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
