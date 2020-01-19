<table class="table table-striped" width="100%">
    <thead>
    <tr>
     {{--   @if (!isset($imprimir))
            <th width="5%">
                <input type="checkbox" class="styled selecionar-todos-registros" data-target="ids[]">
            </th>
        @endif--}}
        <th width="">Descrição</th>
        <th width="10%">Ativo</th>
        <th width="30%">Unidade</th>
        <th width="15%">Atualizado em</th>
        @can(['perfil.alterar', 'perfil.excluir'])
            @if (!isset($imprimir))
                <th width="10%"></th>
            @endif
        @endcan
    </tr>
    </thead>
    <tbody data-link="row" class="rowlink">
    @forelse($dados as $registro)
        <tr>
           {{-- @if (!isset($imprimir))
                <td class="table-inbox-checkbox rowlink-skip">
                    <input type="checkbox" class="styled" name="ids[]" value="{{ $registro->id }}">
                </td>
            @endif--}}
            <td>{{ $registro->nome }}</td>
            <td>{{ $registro->ativo ? 'Sim' : 'Não' }}</td>
            <td>{{ $registro->unidade->descricao }}</td>
            <td>{{ $registro->atualizado_em }}</td>
            @can(['perfil.alterar', 'perfil.excluir'])
                @if (!isset($imprimir))
                    <td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    @can('perfil.alterar')
                                        <li>
                                            <a href="{{ route('perfil.alterar', $registro) }}"><i class="icon-pencil3"></i> Editar</a>
                                        </li>
                                    @endcan

                                    @can('perfil.alterar')
                                        <li>
                                            <a href="{{ route('perfil.alterar', $registro) }}#gerenciarpermissoes"><i class="icon-diff"></i> Permissões</a>
                                        </li>
                                    @endcan

                                    @can('perfil.excluir')
                                        <li>
                                            <a href="{{ route('perfil.excluir', $registro) }}" class="confirma-acao" data-texto="Deseja mesmo excluir este registro?"><i class="icon-trash-alt"></i> Excluir</a>
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
