Vue.component('centro-curso', {
    props: ['centro_curso', 'centro_id'],
    data() {
        return {
            cursos: [],
            remessa: {
                centro_distribuicao_id: this.centro_id,
                curso_id: null,
                tipo_periodo: null,
                quantidade_vaga: null
            }
        }
    },
    beforeMount() {
        cursos = this.centro_curso || [];
        console.log(cursos);
        cursos = cursos.map((curso) => {
            return {
                nota_fiscal: curso.nota_fiscal,
                data: curso.data,
                remessa_inicio: curso.remessa_inicio,
                remessa_fim: curso.remessa_fim,
            }
        });

        this.cursos = cursos

        if (this.cursos.length === 0) {
            this.adicionar();
        }
    },
    methods: {
        /**
         * Adiciona um novo curso para centro de distribuição.
         */
        adicionar() {
            this.cursos.push(Vue.util.extend({}, this.curso));
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

});
