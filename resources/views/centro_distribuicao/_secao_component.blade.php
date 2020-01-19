<secao inline-template :secoes="{{ json_encode($centro_distribuicao->armazem) }}" :unidade="{{ json_encode($centro_distribuicao) }}">

    <div>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <table class="table table-striped" width="100%">
                    <thead>
                    <tr>
                        <th width="">Descrição</th>
                        <th width="">Município</th>
                        <th width="5%" class="text-center">Ativo</th>
                        <th width="1%">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(secao, index) in secoes">

                        <td>@{{ secao.descricao }}</td>
                        <td>@{{ secao.endereco.municipio.descricao }} - @{{ secao.endereco.municipio.descricao }}</td>
                        <td class="text-center">@{{ secao.ativo == 1 ? 'Sim' : 'Não' }}</td>
                        <td>
                            <ul class="icons-list">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a href="#" @click.prevent="editar(secao, index)"><i class="icon-pencil3"></i> Editar</a>
                                            <a href="#" @click.prevent="excluir(secao)"><i class="icon-trash-alt"></i> Excluir</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td v-show="secoes.length <= 0" colspan="5"><em>Nenhum Armazer cadastrado.</em></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</secao>
