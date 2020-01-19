<gerenciar-perfis 
    inline-template 
    :perfis="{{ json_encode($usuario->perfis) }}"
    :usuario-slug="{{ json_encode($registro->slug_id) }}">
    <div>
        <div class="row">
            <div class="col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <label class="need-marked-required">Unidade:</label>
                    <select name="unidade_id" class="form-control  select2 carregar-perfis" data-target="perfil_id">
                        <option value=""></option>
                        @foreach($dependencias['unidades'] as $unidade)
                            <option value="{{ $unidade->id }}" {{ request('unidade_id') == $unidade->id ? 'selected' : '' }}>{{ $unidade->descricao }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 col-lg-4">
                <div class="form-group">
                    <label class="need-marked-required">Perfil:</label>
                    <select name="perfil_id" v-model="perfil_id" v-select="perfil_id" class=" form-control" data-admin="0" data-cidadao="0" data-ativo="1">
                        <option value=""></option>
                        @if (isset($dependencias['perfis']))
                            @foreach($dependencias['perfis'] as $perfil)
                                <option value="{{ $perfil->id }}">{{ $perfil->nome }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <label for="">&nbsp;</label>
                    <button :disabled="!perfil_id || executandoAcao" @click.prevent="adicionarPerfil()" class="btn btn-block btn-info btn-adicionar-perfil" type="button">
                        <i class="icon-plus-circle2"></i> Adicionar perfil
                    </button>
                </div>
            </div>
        </div>

        <hr/>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <table class="table table-striped table-bordered tabela-perfis-atribuidos" width="100%">
                    <thead>
                    <tr>
                        <th width="20%">Unidade</th>
                        <th width="">Perfil</th>
                        <th width="20%">Status</th>
                        <th width="1%">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-if="perfis.length === 0">
                            <td colspan="99">Nenhum perfil atribuído.</td>
                        </tr>
                        <tr class="perfil-atribuido" v-for="(perfil, indexPerfil) in perfis" :key="indexPerfil">
                            <td>@{{ perfil.unidade.descricao }}</td>
                            <td>@{{ perfil.nome }}</td>
                            <td>
                                <span class="label bg-blue" v-if="perfil.pivot.principal === 1">Principal</span>
                                <span class="label bg-warning" v-if="perfil.pivot.ativo === 0">Desativada</span>
                            </td>
                            <td>
                                <ul class="icons-list">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li v-if="perfil.pivot.principal === 0">
                                                <a href="#" @click.prevent="definirPerfilComoPrincipal(perfil)" class="btn-definir-como-principal"><i class="icon-star-full2"></i> Definir como principal</a>
                                            </li>
                                            <li v-if="perfil.pivot.ativo === 0">
                                                <a href="#" @click.prevent="ativarPerfil(perfil)" class="btn-ativar"><i class="icon-checkmark"></i> Ativar</a>
                                            </li>
                                            <li v-if="perfil.pivot.ativo === 1">
                                                <a href="#" @click.prevent="desativarPerfil(perfil)" class="btn-desativar"><i class="icon-blocked"></i> Desativar</a>
                                            </li>
                                            <li>
                                                <a href="#" @click.prevent="removerPerfil(perfil)" class="btn-remover-atribuicao"><i class="icon-trash-alt"></i> Excluir</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</gerenciar-perfis>
