Vue.component('centro-curso', {
    props: ['centro_curso', 'centro', '_cursos', 'tipo_periodos'],
    data() {
        return {
            cursos: [],
            _cursos: [],
            _tipo_periodos: [],
            tipo_periodos: [],
            curso: {
                id: null,
                centro_distribuicao_id: this.centro.id,
                curso_id: null,
                tipo_periodo_id: null,
                data_inicio: null,
                quantidade_vagas: null
            }
        }
    },
    watch: {
        curso_id: function () {
            this.validacao();
            Notifica.info('asdasd')
        },
        tipo_periodo_id: function () {
            this.validacao();
        }
    },
    beforeMount() {
        cursos = this.centro_curso || [];
        _cursos = this._cursos || [];
        _tipo_periodos = this.tipo_periodos || [];
        cursos = cursos.map((curso) => {
            return {
                id: curso.id,
                centro_distribuicao_id: curso.centro_distribuicao_id,
                data_inicio: curso.data_inicio,
                tipo_periodo_id: curso.tipo_periodo_id,
                quantidade_vagas: curso.quantidade_vagas,
                curso_id: curso.curso_id,
            }
        });

        this.cursos = cursos;
        this._cursos = _cursos;
        this._tipo_periodos = _tipo_periodos;

        if (this.cursos.length === 0) {
            this.adicionar();
        }
    },
    methods: {
        validacao() {
            var validos = [];
            /*Valida Estrutura de Cadastro de Cursos Duplicados com (Curso X Periodo)*/
            this.cursos.forEach((item) => {
                var duplicados = validos.findIndex(redItem => {
                    return item.curso_id === redItem.curso_id && item.tipo_periodo_id === redItem.tipo_periodo_id;
                }) > -1;

                if (!duplicados) validos.push(item);
                if (duplicados) Notifica.warning('Este Curso , Já Foi Registrado No Centro de Distribuiçao.', 'Curso e Período Duplicado')

            });

            this.cursos = validos;
        },
        /**
         * Adiciona um novo curso para centro de distribuição.
         */
        adicionar() {
            this.cursos.push(Vue.util.extend({}, this.curso));
            var validos = [];
            /*Valida Estrutura de Cadastro de Cursos Duplicados com (Curso X Periodo)*/
            this.validacao();
        },
        /**
         * Remove um remessa de entrega de medicamentos.
         */
        excluir(index) {
            this.cursos.splice(index, 1);

            if (this.cursos.length === 0) {
                this.adicionar();
            }
        }
    },

})
;
