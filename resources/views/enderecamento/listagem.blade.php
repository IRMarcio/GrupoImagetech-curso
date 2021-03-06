<table class="table table-striped" width="100%">
    <thead>
    <tr>
     {{--   @if (!isset($imprimir))
            <th width="5%">
                <input type="checkbox" class="styled selecionar-todos-registros" data-target="ids[]">
            </th>
        @endif--}}
        <th width="15%">Endereçamento</th>
        <th width="">Tipo de Produto</th>
        <th width="15%">Atualizado em</th>
        @can(['enderecamento.alterar', 'enderecamento.excluir'])
            @if (!isset($imprimir))
                <th width="10%"></th>
            @endif
        @endcan
    </tr>
    </thead>
    <tbody data-link="row" class="rowlink">
    @forelse($dados as $registro)
        <tr>
         {{--   @if (!isset($imprimir))
                <td class="table-inbox-checkbox rowlink-skip">
                    <input type="checkbox" class="styled" name="ids[]" value="{{ $registro->id }}">
                </td>
            @endif--}}
            <td>{{ $registro->endereco_completo }}</td>
            <td>{{ isset($registro->tipoProduto) ? $registro->tipoProduto->descricao : ' - ' }}</td>
            <td>
                {{ $registro->atualizado_em }}
            </td>

            @if(temAlgumaPermissao(['enderecamento.alterar', 'enderecamento.excluir']))
                @if (!isset($imprimir))
                    <td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    @can('enderecamento.alterar')
                                        <li>
                                            <a href="{{ route('enderecamento.alterar', $registro) }}"><i class="icon-pencil3"></i> Editar</a>
                                        </li>
                                    @endcan

                                    @can('enderecamento.excluir')
                                        <li>
                                            <a href="{{ route('enderecamento.excluir', $registro) }}" class="confirma-acao" data-texto="Deseja mesmo excluir este registro?"><i class="icon-trash-alt"></i> Excluir</a>
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
