export default class Notifica {
    /**
     * Exibe mensagem de carregando na tela.
     */
    bloquearTela(mensagem) {
        if (typeof mensagem === 'undefined') {
            mensagem = 'Aguarde, carregando...';
        }

        $.blockUI(
            {
                message: '<span class="text-semibold"><i class="icon-spinner4 spinner position-left"></i>&nbsp; ' + mensagem + '</span>',
                timeout: 7000,
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.10,
                    cursor: 'wait'
                },
                css: {
                    '-webkit-border-radius': 2,
                    '-moz-border-radius': 2,
                    padding: 0,
                    border: 0,
                    backgroundColor: 'transparent'
                }
            }
        );
    }

    /**
     * Remove a mensagem de carregando na tela.
     */
    desbloquearTela() {
        $.unblockUI();
    }

    /**
     * Pergunta ao usuário se ele deseja realmente fazer o que está fazendo.
     */
    confirmaAcao(texto, callbackSim, callbackNao) {
        bootbox.confirm({
            title: "Atenção",
            message: texto,
            buttons: {
                cancel: {
                    label: '<i class="icon-cross3"></i> Não'
                },
                confirm: {
                    label: '<i class="icon-check2"></i> Sim'
                }
            },
            callback: function (result) {
                if (result) {
                    callbackSim()
                } else {
                    if (callbackNao) {
                        callbackNao()
                    }
                }
            }
        });
    }

    sucesso(texto, titulo) {
        this.notificar('sucesso', texto, titulo);
    }

    erro(texto, titulo) {
        this.notificar('erro', texto, titulo);
    }

    info(texto, titulo) {
        this.notificar('info', texto, titulo);
    }

    warning(texto, titulo) {
        this.notificar('warning', texto, titulo);
    }

    notificar(tipo, texto, titulo) {
        let theme;
        switch (tipo) {
            case 'sucesso':
                theme = 'alert-styled-left bg-success';
                break;
            case 'erro':
                theme = 'alert-styled-left bg-danger';
                break;
            case 'info':
                theme = 'alert-styled-left bg-info';
                break;
            case 'warning':
                theme = 'alert-styled-left bg-warning';
                break;
        }

        $.jGrowl.defaults.pool = 5;
        $.jGrowl.defaults.closerTemplate = "<div>[ fechar todas ]</div>";
        $.jGrowl(texto, {
            header: titulo || 'Atenção',
            openDuration: 25,
            theme: theme,
            animateOpen: {opacity: 'show'},
            animateClose: {opacity: 'hide'},
        });
    }
}
