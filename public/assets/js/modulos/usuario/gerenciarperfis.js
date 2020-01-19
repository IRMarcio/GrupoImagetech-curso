Vue.component('gerenciar-perfis', {
    props: ['perfis', 'usuario-slug'],
    data() {
        return {
            executandoAcao: false,
            perfil_id: null,
            perfis: [],
        }
    },
    mounted() {
        $(() => {
            $('body').on('perfisCarregados', () => {
                this.limparPerfisJaAtribuidos()
            })
        })
    },
    methods: {
        carregarPerfisAtribuidos(callback) {
            const url = constants.SITE_PATH + '/usuarios/perfis/perfis-atribuidos';

            this.$http.post(url, {
                usuario_slug_id: this.usuarioSlug
            }).then((response) => {
                this.perfis = response.body.data
            }).then(callback())
        },
        limparPerfisJaAtribuidos() {
            $select = $('select[name="perfil_id"]')
            $select.find('option').map((index, option) => {
                const indexEncontrado = this.perfis.findIndex((f) => f.id === parseInt($(option).val()))

                if (indexEncontrado !== -1) {
                    $select.find(`option[value="${$(option).val()}"]`).detach()
                }
            })
        },
        adicionarPerfil() {
            this.executandoAcao = true
            this.$http.post(constants.SITE_PATH + '/usuarios/perfis/adicionar', {
                usuario_slug_id: this.usuarioSlug,
                perfil_id: this.perfil_id,
            }).then((response) => {
                if (response.body === false) {
                    throw 'Falha na adição do perfil'
                }

                this.carregarPerfisAtribuidos(() => {
                    Notifica.sucesso('Perfil adicionado com sucesso!')
                })
            }).catch((e) => {
                var body = e.body;
                var mensagem = 'Houve um erro ao adicionar o perfil, contate o suporte técnico.';

                if (body.data && body.data.errors) {
                    var erros = body.data.errors.join('<br>');
                    Notifica.erro(erros, 'Atenção');
                    return false;
                }
            }).then(() => {
                this.executandoAcao = false
                this.perfil_id = null

                const $selectUnidade = $('[name="unidade_id"]')

                if ($selectUnidade.prop('tagName') === 'SELECT') {
                    $selectUnidade.val('');
                    $selectUnidade.trigger('change');
                }
            })
        },
        validarRemocaoPerfil(perfilId, callback) {
            this.$http.post(constants.SITE_PATH + '/usuarios/perfis/validar-remocao-perfil', {
                usuario_slug_id: this.usuarioSlug,
                perfil_id: perfilId,
            }).then((response) => {
                if (response.body === false) {
                    throw 'Registro possui depêndencias'
                }

                callback()
            }).catch((e) => {
                Notifica.erro('Não foi possível excluir este perfil, ele está relacionado com outros registros no sistema.', 'Validação');
            })
        },
        removerPerfil(perfil) {
            this.validarRemocaoPerfil(perfil.id, () => {
                this.$http.post(constants.SITE_PATH + '/usuarios/perfis/remover', {
                    usuario_slug_id: this.usuarioSlug,
                    perfil_id: perfil.id,
                }).then((response) => {
                    if (response.body === false) {
                        throw 'Registro possui depêndencias'
                    }

                    this.carregarPerfisAtribuidos(() => {
                        Notifica.sucesso(`Perfil ${perfil.nome} removido com sucesso!`)
                    })
                }).catch((e) => {
                    var body = e.body;
                    var mensagem = 'Houve um erro ao remover o perfil, contate o suporte técnico.';
    
                    if (body.data && body.data.errors) {
                        var erros = body.data.errors.join('<br>');
                        Notifica.erro(erros, 'Atenção');
                        return false;
                    }
                })
            })  
        },
        definirPerfilComoPrincipal(perfil) {
            this.$http.post(constants.SITE_PATH + '/usuarios/perfis/definir-como-principal', {
                usuario_slug_id: this.usuarioSlug,
                perfil_id: perfil.id,
            }).then((response) => {
                if (response.body === false) {
                    throw 'Falha ao definir perfil como principal'
                }

                this.carregarPerfisAtribuidos(() => {
                    Notifica.sucesso(`Perfil ${perfil.nome} definido como principal!`)
                })
            }).catch((e) => {
                var body = e.body;
                var mensagem = 'Houve um erro ao definir perfil como princpal, contate o suporte técnico.';

                if (body.data && body.data.errors) {
                    var erros = body.data.errors.join('<br>');
                    Notifica.erro(erros, 'Atenção');
                    return false;
                }
            })
        },
        ativarPerfil(perfil) {
            this.$http.post(constants.SITE_PATH + '/usuarios/perfis/ativar', {
                usuario_slug_id: this.usuarioSlug,
                perfil_id: perfil.id,
            }).then((response) => {
                if (response.body === false) {
                    throw 'Falha ao ativar perfil'
                }

                this.carregarPerfisAtribuidos(() => {
                    Notifica.sucesso(`Perfil ${perfil.nome} ativado com sucesso!`)
                })
            }).catch((e) => {
                var body = e.body;
                var mensagem = 'Houve um erro ao ativar o perfil, contate o suporte técnico.';

                if (body.data && body.data.errors) {
                    var erros = body.data.errors.join('<br>');
                    Notifica.erro(erros, 'Atenção');
                    return false;
                }
            })
        },
        desativarPerfil(perfil) {
            this.$http.post(constants.SITE_PATH + '/usuarios/perfis/desativar', {
                usuario_slug_id: this.usuarioSlug,
                perfil_id: perfil.id,
            }).then((response) => {
                if (response.body === false) {
                    throw 'Falha ao desativar perfil'
                }

                this.carregarPerfisAtribuidos(() => {
                    Notifica.sucesso(`Perfil ${perfil.nome} desativado com sucesso!`)
                })
            }).catch((e) => {
                var body = e.body;
                var mensagem = 'Houve um erro ao desativar o perfil, contate o suporte técnico.';

                if (body.data && body.data.errors) {
                    var erros = body.data.errors.join('<br>');
                    Notifica.erro(erros, 'Atenção');
                    return false;
                }
            })
        },
    }
});