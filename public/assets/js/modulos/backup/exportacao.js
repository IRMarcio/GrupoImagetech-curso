Vue.component('backup-exportacao', {
    data() {
        return {
            downloadUrl: '#',
            exportando: false,
            exportado: false,
            erro: false,
        };
    },
    mounted() {
        this.conectarSocket();
    },
    methods: {
        /**
         * Inicia a exportação do banco de dados.
         */
        iniciarExportacao() {
            this.exportado = false;
            this.exportando = true;
            this.erro = false;
            this.$http.post(constants.URL_MODULO + '/backup/exportar');
        },

        /**
         * Escuta o evento para saber quando a exportação foi finalizada.
         * @returns {boolean}
         */
        conectarSocket() {
            try {
                Echo.channel('backup').listen('.backup.exportacao_finalizada', (e) => {
                    if (e.dados.status !== 0) {
                        this.erro = true;
                        Notifica.erro("Houve um erro ao exportar o banco de dados, contate o suporte técnico.")
                    }

                    if (e.dados.status === 0) {
                        this.erro = false;

                        if (e.dados.arquivo) {
                            this.downloadUrl = e.dados.arquivo;
                        }

                        Notifica.sucesso("O banco de dados foi exportado com sucesso.")
                    }

                    this.exportado = true;
                    this.exportando = false;
                });

            } catch (error) {
                Notifica.erro("Não foi possível se conectar ao socket. Por favor, certifique-se que o socket esteja rodando no servidor.");
                return false;
            }
        }
    }
});
