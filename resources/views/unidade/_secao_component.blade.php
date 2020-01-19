<secao inline-template :secoes="{{ json_encode($unidade->secoes) }}" :unidade="{{ json_encode($unidade) }}">
    <div>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-9">
                <div class="form-group">
                    <label class="need-marked-required">Descrição:</label>
                    <input :disabled="acaoEmExecucao" type="text" class="form-control" v-model="secao.descricao" maxlength="200"/>
                </div>
            </div>
            <div class="col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <label class="need-marked-required">Ativo:</label>
                    <select :disabled="acaoEmExecucao" class="form-control" v-select="secao.ativo" v-model="secao.ativo">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-1">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button :disabled="acaoEmExecucao" @click="salvar" class="btn btn-block btn-info" type="button">
                        <i v-show="acao == 'adicionar'" class="icon-plus-circle2"></i>
                        <i v-show="acao == 'alterar'" class="icon-pencil3"></i>
                    </button>
                </div>
            </div>
        </div>

        <hr/>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <table class="table table-striped" width="100%">
                    <thead>
                    <tr>
                        <th width="">Descrição</th>
                        <th width="5%" class="text-center">Ativo</th>
                        <th width="1%">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(secao, index) in secoes">
                        <td>@{{ secao.descricao }}</td>
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
                        <td v-show="secoes.length <= 0" colspan="5"><em>Nenhuma seção cadastrada.</em></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</secao>
