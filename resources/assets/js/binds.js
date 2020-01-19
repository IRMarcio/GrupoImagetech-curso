import {registerMasks} from './masks';
import {registerPlugins} from "./plugins";

export const registerBinds = () => {
    clearTimeInput();
    setAutoFocus();
    ativarTabsDinamicas();
    modalBinds();
    excluirVariosAlert();
};


/**
 * Limpa o valor do campo time se o horário for invalido
 */
const clearTimeInput = () => {
    $(document).on('blur', '[type="time"]', function (e) {
        if (e.target.value === '') {
            $(this).val('');
        }
    });
};

/**
 * Seta o foco no primeiro campo com autofocus que achar na tela.
 */
const setAutoFocus = () => {
    const $autofocus = $('[autofocus]');
    if ($autofocus.length) {
        $autofocus[0].focus();
    }
};

/**
 * Ao clicar em alguma tab a URL é atualizada.
 */
const ativarTabsDinamicas = () => {
    const url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
    }

    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        if (history.pushState) {
            history.pushState(null, null, e.target.hash);
        } else {
            window.location.hash = e.target.hash;
        }
    })
};

/**
 * Alguns binds em modais
 */
var vueModal = null;
const modalBinds = () => {
    $('.modal-white').on('show.bs.modal', function (e) {
        setTimeout(function () {
            $('.modal-backdrop').addClass('modal-backdrop-white');
        });
    });

    $('.modal-ajax').on('loaded.bs.modal', function (e) {
        vueModal = (new (Vue.extend(app))).$mount($(this).find(".modal-content")[0]);
        registerMasks($(this));
        registerPlugins($(this));
    })

    $('.modal-ajax').on('show.bs.modal', function (e) {
        const $this = $(this);
        $this.find('.modal-content').html('<i style="margin: 0 auto;padding:25px;" class="icon-spinner2 spinner position-left"></i>');
    })
        .on('hidden.bs.modal', function (e) {
            if ($(e.target).attr('data-refresh') === 'true') {
                $(this).removeData('bs.modal');
                $(this).find(".modal-content").children().off();
                $(this).find(".modal-content").children().unbind();
                $(this).find(".modal-content").children().remove();

                if (vueModal != null) {
                    vueModal.$destroy();
                    vueModal = null;
                }
            }
        });

    $(document).on('show.bs.modal', '.modal', function (event) {
        const zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function () {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });
};

/**
 * Exibe um alerta quando o usuário for tentar excluir
 */
const excluirVariosAlert = () => {
    // Rotina para excluir varios registros da listagem de registros
    $('.acoes-com-registros-selecionados a.excluir-varios').on('click', function (e) {
        e.preventDefault();
        var marcados = $('input[name="ids[]"]:checked'),
            href = $(this).attr('href');

        if (marcados.length === 0) {
            return;
        }

        var ids = [];
        marcados.each(function (i, id) {
            ids.push(id.value);
        })

        Sistema.confirmaAcao("Deseja mesmo excluir o(s) registro(s) selecionado(s)?", function () {
            $.post(href, {ids: ids}, function (retorno) {
                if (retorno.sucesso) {
                    window.location.reload();
                } else {
                    Notifica.erro('Houve um erro ao excluir um ou mais registros.');
                }
            }).fail(function () {
                Notifica.erro('Houve um erro ao excluir um ou mais registros.');
            })
        });
    });
};
