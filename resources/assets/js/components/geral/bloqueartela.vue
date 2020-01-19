<template>
    <div class="page-container">

      <!-- Page content -->
      <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <form action="#" class="login-form form-validate" method="POST" v-on:submit.prevent="desbloquearTela()">
                <div class="panel panel-body">
                    <div class="text-center">
                        <div class="hidden-xs icon-object border-warning-400 text-warning-400"><i class="icon-people"></i>
                        </div>
                        <h5 class="content-group-lg">Tela bloqueada
                            <small class="display-block">Informe sua senha para desbloqueá-la</small>
                        </h5>
                    </div>

                    <div class="form-group has-feedback has-feedback-left">
                        <input autofocus type="password" v-model="credenciais.password" class="form-control" placeholder="Senha" required name="password">
                        <div class="form-control-feedback">
                            <i class="icon-lock2 text-muted"></i>
                        </div>
                    </div>

                    <div class="form-group login-options">
                        <div class="row">
                            <div class="col-sm-12 mt-15">
                                <a :href="urlLogout">Efetuar logout</a>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-desbloquear btn bg-blue btn-block">Desbloquear
                        <i class="icon-circle-right2 position-right"></i>
                    </button>
                </div>
                <small>{{ sistema.titulo }} - {{ sistema.fornecedor }} - {{ sistema.versao }}</small>
            </form>

        </div>
        <!-- /main content -->

      </div>
      <!-- /page content -->

    </div>
    <!-- /page container -->
</template>

<script>
    export default {
        props: ['sistema', 'loginRoute', 'login'],
        data() {
            return {
                urlLogout: null,
                credenciais:  {
                    login: null,
                    password: null,
                }
            }
        },
        mounted() {
            this.urlLogout = constants.SITE_PATH + '/logout'
            this.credenciais.login = this.login
        },
        methods: {
            desbloquearTela() {
                $('.btn-desbloquear').loading();
                this.$http.post(this.loginRoute, {
                    login: this.credenciais.login,
                    password: this.credenciais.password,
                    acao: 'desbloquear-tela'
                }).then(function (response) {
                    if (response.data === true) {
                        this.$parent.desbloquearTela()
                    }
                }).catch((e) => {
                    var body = e.body
                    var mensagem = '.';

                    if (body.data && body.data.errors) {
                        var erros = body.data.errors.join('<br>')
                        Notifica.erro(erros, 'Atenção')
                        return
                    }
                }).then(() => {
                    $('.btn-desbloquear').loading(false);
                    this.credenciais.password = ''
                })
            },
        }
    }
</script>
