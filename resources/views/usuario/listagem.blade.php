<table class="table table-striped" width="100%">
    <thead>
    <tr>
        {{--@if (!isset($imprimir))
            <th width="5%">
                <input type="checkbox" class="styled selecionar-todos-registros" data-target="ids[]">
            </th>
        @endif--}}
        <th width="45%">Nome</th>
        <th width="10%">&nbsp;</th>
        <th width="15%">CPF</th>
        <th width="15%">Atualizado em</th>
        @can(['usuario.alterar', 'usuario.excluir'])
            @if (!isset($imprimir))
                <th width="10%"></th>
            @endif
        @endcan
    </tr>
    </thead>
    <tbody data-link="row" class="rowlink">
    @forelse($dados as $registro)
        <tr class="{{ $registro->temSituacao('inativo') ? 'inativo' : '' }}">
            {{--@if (!isset($imprimir))
                <td class="table-inbox-checkbox rowlink-skip">
                    <input type="checkbox" class="styled" name="ids[]" value="{{ $registro->id }}">
                </td>
            @endif--}}
            <td>
                {{ $registro->nome }}
            </td>
            <td>
                @foreach($registro->situacoes as $situacao)
                    <span class="label label-default">
			            {{ $situacao->descricao }}
                    </span>
                @endforeach
            </td>
            <td>{{ formatarCpf($registro->cpf) }}</td>
            <td>
                {{ $registro->atualizado_em }}
            </td>

            @if(temAlgumaPermissao([
                'usuario.alterar',
                'usuario.excluir',
                'usuario.permissoes',
                'usuario.invalidar_senha',
                'usuario.ativar',
                'usuario.desativar',
                'usuario.desbloquear_tentativas',
            ]))
                @if (!isset($imprimir))
                    <td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    @can('usuario.alterar')
                                        <li>
                                            <a href="{{ route('usuario.alterar', $registro) }}"><i class="icon-pencil3"></i> Editar</a>
                                        </li>
                                    @endcan

                                    @can('usuario.permissoes')
                                        <li>
                                            <a href="{{ route('usuario.permissoes', $registro) }}"><i class="icon-diff"></i> Permissões</a>
                                        </li>
                                    @endcan

                                    @can('usuario.excluir')
                                        <li>
                                            <a href="{{ route('usuario.excluir', $registro) }}" v-confirma-exclusao><i class="icon-trash-alt"></i> Excluir</a>
                                        </li>
                                    @endcan

                                    @can('usuario.invalidar_senha')
                                        @if (!$registro->super_admin && !$registro->temSituacao('senha_invalidada'))
                                            <li>
                                                <a href="{{ route('usuario.invalidar_senha', $registro) }}"><i class="icon-alert"></i> Invalidar senha</a>
                                            </li>
                                        @endif
                                    @endcan

                                    @if ($registro->temSituacao('inativo'))
                                        @can('usuario.ativar')
                                            <li>
                                                <a href="{{ route('usuario.ativar', $registro) }}">
                                                    <i class="icon-check"></i> Ativar
                                                </a>
                                            </li>
                                        @endcan
                                    @endif

                                    @if ($registro->temSituacao('inativo') == false)
                                        @can('usuario.desativar')
                                            <li>
                                                <a href="{{ route('usuario.desativar', $registro) }}">
                                                    <i class="icon-blocked"></i> Desativar
                                                </a>
                                            </li>
                                        @endcan
                                    @endif

                                    @if ($registro->temSituacao('bloqueado_tentativa'))
                                        @can('usuario.desbloquear_tentativas')
                                            <li>
                                                <a href="{{ route('usuario.desbloquear_tentativas', $registro) }}">
                                                    <i class="icon-check"></i> Desbloquear
                                                </a>
                                            </li>
                                        @endcan
                                    @endif
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
