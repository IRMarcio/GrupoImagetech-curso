<script>
    const listenerBack = function () {
        history.pushState(null, null, document.URL);
    }

    export default {
        data() {
            return {
                telaBloqueada: false,
                slugId: null,
                sistema: null,
                loginRoute: null,
                bloqueioTelaRoute: null,
                login: null,
            }
        },
        mounted() {
            this.slugId = this.$el.attributes.slugId.value
            this.sistema = JSON.parse(this.$el.attributes.sistema.value)
            this.loginRoute = this.$el.attributes.loginRoute.value
            this.bloqueioTelaRoute = this.$el.attributes.bloqueioTelaRoute.value
            this.login = this.$el.attributes.login.value

            $(() => {
                if (!this.slugId || window.Echo === undefined || window.Echo.private === undefined) {
                    return
                }

                // Listener dos events de sessão
                // window.Echo.private(`sessao.${this.slugId}`).listen('.sessao.forcar_logout', (e) => {
                //     window.location.href = constants.SITE_PATH + '/login'
                // })

                // window.Echo.channel('sessao').listen('.sessao.forcar_logout', (e) => {
                //     window.location.href = constants.SITE_PATH + '/logout'
                // });

                // window.Echo.private(`sessao.${this.slugId}`).listen('.sessao.bloquear_tela', (e) => {
                //     this.bloquearTela()
                // })

                // window.Echo.private(`sessao.${this.slugId}`).listen('.sessao.desbloquear_tela', (e) => {
                //     this.desbloquearTela()
                // })
            })
        },
        methods: {
            solicitarBloqueioTela() {
                this.bloquearTela()
                this.$http.post(this.bloqueioTelaRoute).then(function (response) {
                    if (response.data !== true) {
                        this.desbloquearTela()
                    }
                }).catch((e) => {
                    this.desbloquearTela()

                    var body = e.body
                    var mensagem = '.';

                    if (body.data && body.data.errors) {
                        var erros = body.data.errors.join('<br>')
                        Notifica.erro(erros, 'Atenção')
                        return
                    }
                })
            },
            bloquearTela() {
                // Se tela já está bloqueada, retorna
                if (this.telaBloqueada === true) {
                    return
                }

                const blocoId = '#bloco-bloqueio'
                const ComponentVue = Vue.extend(Vue.component('bloqueartela'))

                // Adiciona uma div onde o component será rendereizado
                $(blocoId).append('<div>')

                // Renderiza o componente
                new ComponentVue({
                    propsData: {
                        sistema: this.sistema,
                        loginRoute: this.loginRoute,
                        login: this.login
                    }
                }).$mount(blocoId + ' div');

                // Adiciona class de login no body
                $('body').addClass('login-container bg-slate-800')

                // Seta tela bloqueada
                this.telaBloqueada = true

                // Caso usuário clique no botão volta do browser, a página anterior será a de logout
                history.pushState(null, null, document.URL);
                window.addEventListener('popstate', listenerBack, true);
            },
            desbloquearTela() {
                // Remove o bloco de bloqueio
                const blocoId = '#bloco-bloqueio'
                $(blocoId).find('div').remove()

                // Remove class de login no body
                $('body').removeClass('login-container bg-slate-800')

                this.telaBloqueada = false

                window.removeEventListener('popstate', listenerBack, true)
                window.addEventListener('popstate', function () {
                    history.back()
                }, true);
            },
        }
    }
</script>
