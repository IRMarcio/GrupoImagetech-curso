            <div class="col-sm-12 col-md-12 col-lg-12">
                <table class="table table-striped" width="100%">
                    <thead>
                    <tr>

                        <th width="">Descrição</th>
                        <th width="20%">Município</th>
                        <th width="10%">Ativo</th>
                        <th width="15%">Atualizado em</th>
                        @if (!isset($imprimir))
                            @can(['centro_distribuicao.alterar', 'centro_distribuicao.excluir'])
                                <th width="10%"></th>
                            @endcan
                        @endif
                    </tr>
                    </thead>
                    <tbody data-link="row" class="rowlink">
                    @forelse($centro_distribuicao->armazem as $registro)
                        <tr>
                            <td>{{ $registro->descricao }}</td>
                            <td>{{ $registro->endereco ? ($registro->endereco->municipio->descricao . '/' . $registro->endereco->municipio->uf->uf) : '' }}</td>
                            <td>{{ $registro->ativo ? 'Sim' : 'Não' }}</td>
                            <td>
                                {{ $registro->atualizado_em }}
                            </td>

                            @if(temAlgumaPermissao(['centro_distribuicao.alterar_armazens', 'centro_distribuicao.excluir']))
                                @if (!isset($imprimir))
                                    <td class="text-center">
                                        <ul class="icons-list">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                                            class="icon-menu9"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    @can('centro_distribuicao.alterar')
                                                        <li>
                                                            <a href="{{ route('centro_distribuicao.alterar_armazens',[ $registro->id,$centro_distribuicao->id]) }}"><i
                                                                        class="icon-pencil3"></i> Editar</a>
                                                        </li>
                                                    @endcan
                                                    @can('centro_distribuicao.excluir')
                                                        <li>
                                                            <a href="{{ route('centro_distribuicao.excluir', $registro) }}"
                                                               v-confirma-exclusao><i class="icon-trash-alt"></i>
                                                                Excluir</a>
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
            </div>
