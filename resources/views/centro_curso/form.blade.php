
<centro-curso inline-template
                               :centro_curso="{{ json_encode(isset($entregaMedicamentos) ? $entregaMedicamentos->remessas: []) }}"
                               :centr0_id="0"     >
    <div>
        <button type="button" @click="adicionar" class="btn btn-default pull-right">
            Adicionar Remessas
        </button>
        <table class="table " width="100%">
            <thead>
            <tr>
                <th>Nota Fiscal</th>
                <th>Data</th>
                <th>Remessa de:</th>
                <th>Remessa Até:</th>
            </tr>
            </thead>
            <tbody v-for="(curso, index) in cursos">

            <tr>
                <td style="padding: 0px" width="20%">
                    <input class="form-control" type="text" v-model.lazy="curso.nota_fiscal"
                           :name="'cursos['+ index +'][nota_fiscal]'"/>
                </td>
                <td style="padding: 0px" width="20%">
                    <input class="form-control" type="date" v-model.lazy="curso.data"
                           :name="'cursos['+ index +'][data]'"
                           required/>
                </td>

                <td style="padding: 0px" width="20%">
                    <input class="form-control" type="number" v-model.lazy="curso.curso_inicio"
                           :name="'cursos['+ index +'][curso_inicio]'"/>
                </td>
                <td style="padding: 0px" width="20%">
                    <input class="form-control" type="number" v-model.lazy="curso.curso_fim"
                           :name="'cursos['+ index +'][curso_fim]'"/>
                </td>
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
