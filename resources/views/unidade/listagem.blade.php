<table class="table table-striped" width="100%">
    <thead>
    <tr>
{{--
        @if (!isset($imprimir))
            <th width="5%">
                <input type="checkbox" class="styled selecionar-todos-registros" data-target="ids[]">
            </th>
        @endif
--}}
        <th width="">Descrição</th>
        <th width="20%">Município</th>
        <th width="10%">Ativo</th>
        <th width="15%">Atualizado em</th>
        @if (!isset($imprimir))
            @can(['unidade.alterar', 'unidade.excluir'])
                <th width="10%"></th>
            @endcan
        @endif
    </tr>
    </thead>
    <tbody data-link="row" class="rowlink">
    @forelse($dados as $registro)
        <tr>
            {{--@if (!isset($imprimir))
                <td class="table-inbox-checkbox rowlink-skip">
                    <input type="checkbox" class="styled" name="ids[]" value="{{ $registro->id }}">
                </td>
            @endif--}}
            <td>{{ $registro->descricao }}</td>
            <td>{{ $registro->municipio ? ($registro->municipio->descricao . '/' . $registro->municipio->uf->uf) : '' }}</td>
            <td>{{ $registro->ativo ? 'Sim' : 'Não' }}</td>
            <td>
                {{ $registro->atualizado_em }}
            </td>

            @if(temAlgumaPermissao(['unidade.alterar', 'unidade.excluir']))
                @if (!isset($imprimir))
                    <td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    @can('unidade.alterar')
                                        <li>
                                            <a href="{{ route('unidade.alterar', $registro) }}"><i class="icon-pencil3"></i> Editar</a>
                                        </li>
                                    @endcan

                                    @can('unidade.alterar')
                                        <li>
                                            <a href="{{ route('unidade.alterar', $registro) }}#secoes"><i class="icon-grid"></i> Seções</a>
                                        </li>
                                    @endcan

                                    @can('unidade.excluir')
                                        <li>
                                            <a href="{{ route('unidade.excluir', $registro) }}" v-confirma-exclusao><i class="icon-trash-alt"></i> Excluir</a>
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
