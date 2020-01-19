Vue.component('backup-importacao', {
    props: ['registros'],
    data() {
        return {
            registroSelecionado: null,
            arquivoOpcao: 'upload',
            arquivo: null,
            importando: false,
            progressoUpload: 0
        };
    },
    mounted() {
    },
    methods: {
        selecionar(registro) {
            this.registroSelecionado = registro;
            this.exibirPainel($('#painel-selecionado'));
            this.esconderPainel($('#painel-registros'));
        },

        alterarSelecionado() {
            this.exibirPainel($('#painel-registros'));
            this.esconderPainel($('#painel-selecionado'));
        },

        /**
         * Exibe um painel.
         */
        exibirPainel(elemento) {
            let $painel = elemento;
            $painel.find('.panel-body').slideDown(150);
            $painel.find('.panel-footer').slideDown(150);
            $painel.removeClass("panel-collapsed");
        },

        /**
         * Esconde um painel.
         */
        esconderPainel(elemento) {
            let $painel = elemento;
            $painel.find('.panel-body').slideUp(150);
            $painel.find('.panel-footer').slideUp(150);
            $painel.addClass("panel-collapsed");
        },

        /**
         * Inicia a importação do arquivo selecionado ou do arquivo do backup selecionado.
         */
        iniciarImportacao() {
            const arquivo = this.$refs.arquivo.files[0];

            if (arquivo !== null) {
                const valido = this.validarArquivo(arquivo);
                if (!valido) {
                    Notifica.erro("Por favor, selecione um arquivo válido (*.sql)!");
                    return false;
                }
            }

            this.importando = true;

            // Depois das validações, inicia a importação
            const formData = new FormData();

            //  Se tiver arquivo selecionado
            if (arquivo) {
                formData.append('arquivo', arquivo);
            }
            formData.append('id', this.registroSelecionado.id);

            // Inicia a importação
            this.conectarSocket();

            const self = this;
            this.$http.post(constants.URL_MODULO + '/backup/importar', formData, {
                progress(e) {
                    if (e.lengthComputable) {
                        self.progressoUpload = Math.round(((e.loaded / e.total) * 100));
                    }
                }
            }).then((e) => {
                if (e.body.data === false) {
                    this.importando = false;
                    Notifica.erro(e.body.error);
                    return false;
                }
            });
        },

        /**
         * Valida se o arquivo selecionado pelo usuáro é válido.
         *
         * @param arquivo
         * @returns {boolean}
         */
        validarArquivo(arquivo) {
            return arquivo.name.split('.').pop() == 'sql';
        },

        /**
         * Escuta o evento para saber quando a importação foi finalizada.
         * @returns {boolean}
         */
        conectarSocket() {
            try {
                Echo.channel('backup').listen('.backup.importacao_finalizada', (e) => {
                    if (e.dados.status !== 0) {
                        this.erro = true;
                        Notifica.erro(e.dados.mensagem)
                    }

                    if (e.dados.status === 0) {
                        this.erro = false;
                        Notifica.sucesso("A importação foi realizada com sucesso.")
                    }

                    this.importando = false;
                });

            } catch (error) {
                Notifica.erro("Não foi possível se conectar ao socket. Por favor, certifique-se que o socket esteja rodando no servidor.");
                return false;
            }
        }
    }
});
