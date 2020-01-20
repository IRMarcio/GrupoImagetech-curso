Vue.component('form-us', {
    props: ['alunos', 'matricula'],
    data() {
        return {
            alunos_id: null,
            aluno: [],
            selecionado: [],
            validacao: [],
        }
    },
    watch: {
        'alunos_id': function (val) {
            this.changeAluno(val)
        }
    },
    mounted: function () {

        if (this.matricula)
            this.alunos_id = this.matricula.id
    },
    methods: {
        /**
         * Inicia o Busca de dados de alunos selecionado.
         *
         * @param index
         */
        changeAluno(index) {
            this.aluno = this.alunos.filter(function (aluno) {
                return aluno.id === parseInt(index)
            });
        },

        /**
         * Inicia o salvamento da unidade, mas antes faz a validação dos dados.
         *
         * @param e
         */
        salvar(e) {
            // Só vamos validar o resto dos dados de outras abas se o formulario principal estiver valido
            let formularioValido = $(this.$el).valid(), self = this;
            if (formularioValido) {
                // Valida as escalas de cada tipo de atendimento, separadamente
                let valido = true;

                if (!valido) {
                    e.preventDefault();
                    return;
                }
            }
        },

    }
});
