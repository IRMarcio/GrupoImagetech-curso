Vue.component('form-us', {
    props: ['alunos', 'matricula', 'cursos_add'],
    data() {
        return {
            alunos_id: null,
            centro_cursos_id: null,
            aluno: [],
            selecionado: [],
            validacao: [],
            cursos: [],
            $valida: [true]
        }
    },
    watch: {
        'alunos_id': function (val) {
            this.changeAluno(val)
        },
        'centro_cursos_id': function (val) {
            if (val)
                this.validaPeriodo(val)
        }
    },
    mounted: function () {
        if (this.matricula) {
            this.alunos_id = this.matricula.alunos_id
            this.centro_cursos_id = this.matricula.centro_cursos_id
        }

    },
    methods: {
        /**
         * Inicia o Busca de dados de alunos selecionado.
         *
         * @param index
         */
        changeAluno(index) {
            if (this.matricula.length === 0) {
                this.centro_cursos_id = null
            }
            this.aluno = this.alunos.filter(function (aluno) {
                return aluno.id === parseInt(index)
            });
            if (this.aluno[0]) {
                this.cursos = this.aluno[0].matricula
            }
        },
        /** Inicia o Busca de dados de alunos selecionado.
         *
         * @param index
         */
        validaPeriodo(index) {
            /*Curso a disposição do Núcleo estudantil*/
            let cursos_add = this.cursos_add.filter(function (curso) {
                return curso.id === parseInt(index)
            });
            /*Curso Matriculado do aluno*/
            this.cursos.map(item => {
                this.verificaObject(item, cursos_add)
            })

            /*Realiza Verificação de Período e Curso*/
            if (this.$valida.length > 0 && this.$valida[0] === false) {
                Notifica.info(this.$valida[1])
                this.centro_cursos_id = null
                this.$valida = [true];
            }
        },
        verificaObject(item, curso_add) {
            if (curso_add[0]) {
                var valida = true,
                    $mensagem = '',
                    curso = curso_add[0].curso;

                item.centro_cursos.map((itens) => {
                    console.log()
                    if (itens.curso.id === curso.id || itens.tipo_periodo_id === curso_add[0].tipo_periodo_id) {
                        this.$valida = [
                            valida = false,
                            $mensagem = ' Curso Ou Período Já Regitrado Para Este Aluno '
                        ]
                    }
                });
            }


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
                // Valida as escalas de cada tipo do formulário, separadamente
                let valido = true;

                if (!valido) {
                    e.preventDefault();
                    return;
                }
            }
        }
    }
});
