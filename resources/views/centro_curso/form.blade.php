<centro-curso inline-template
              :centro_curso="{{ json_encode(isset($centroCursos) ? $centroCursos : []) }}"
              :centro="{{ json_encode(isset($centro) ? $centro : []) }}"
              :_cursos="{{ json_encode(isset($cursos) ? $cursos : [])  }}"
              :tipo_periodos="{{ json_encode(isset($tipoPeriodos) ? $tipoPeriodos : [])  }}"

>
    <div>
        <button type="button" @click="adicionar" class="btn btn-default pull-right">
            Adicionar Remessas
        </button>
        <table class="table " width="100%">
            <thead>
            <tr>
                <th>Curso</th>
                <th>Período</th>
                <th>Quantidade Vagas:</th>
                <th>Data Início:</th>
            </tr>
            </thead>
            <tbody v-for="(curso, index) in cursos">

            <tr>
                <td>
                    <select @change="validacao" :name="'cursos['+ index +'][curso_id]'" v-model.lazy="curso.curso_id"
                            v-select="curso.curso_id" style="width: 300px !important;">
                        <option v-for="_curso in _cursos" :value="_curso.id">
                            @{{ _curso.descricao }}
                        </option>
                    </select>
                </td>
                <td>
                    <select @change="validacao" :name="'cursos['+ index +'][tipo_periodo_id]'" v-model.lazy="curso.tipo_periodo_id"
                            v-select="curso.tipo_periodo_id" style="width: 300px !important;">
                        <option v-for="_tipo_periodo in _tipo_periodos" :value="_tipo_periodo.id">
                            @{{ _tipo_periodo.descricao }}
                        </option>
                    </select>
                </td>

                <td style="padding: 0px" width="20%">
                    <input class="form-control" type="number" v-model.lazy="curso.quantidade_vagas"
                           :name="'cursos['+ index +'][quantidade_vagas]'"/>
                </td>
                <td style="padding: 0px" width="20%">
                    <input class="form-control" type="date" v-model.lazy="curso.data_inicio"
                           :name="'cursos['+ index +'][data_inicio]'"
                           required/>
                </td>
                <input type="hidden" v-model.lazy="curso.centro_distribuicao_id"
                       :name="'cursos['+ index +'][centro_distribuicao_id]'"/>

                <input type="hidden" v-model.lazy="curso.id"
                       :name="'cursos['+ index +'][id]'"/>
                <td>
                    <button type="button" @click="excluir(index)" title="Excluir"
                            class=" btn btn-default btn-block btn-sx" style="padding: 2px">
                        <i class="fa fa-trash"></i> Excluir
                    </button>
                </td>
            </tr>
            <tr>
                <td colspan="9999" style="background: #0c5460; padding: 1px !important;"></td>
            </tr>
            </tbody>
        </table>
        <br/>
    </div>
</centro-curso>
