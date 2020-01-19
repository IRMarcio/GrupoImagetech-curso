Vue.component('form-us', {
    data() {
        return {
            validacao: [],
        }
    },
    computed: {
        
    },
    mounted() {
        
    },
    methods: {
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
