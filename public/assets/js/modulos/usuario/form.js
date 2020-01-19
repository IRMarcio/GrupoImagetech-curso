// Inicializa controle do form do usuário
let UsuarioForm;

$(function () {
    UsuarioForm = {
        init: function () {
            UsuarioForm.binds();
            UsuarioForm.plugins();
            UsuarioForm.listeners();
        },
        binds: function () {
            const $document = $(document);

            $document.on('blur', 'input[name="cpf"]', function (e) {
                if ($(this).valid() && $(this).prop('readonly') === false) {
                    UsuarioForm.validarCpf(e.target.value);
                }
                e.stopImmediatePropagation()
            });

            $document.on('click', '.remover-situacao', function (e) {
                e.preventDefault();
                UsuarioForm.removerSituacao(e.target.href);
                e.stopImmediatePropagation()
            });

            UsuarioForm.bloquearCpf();
        },
        listeners: function () {
            
        },
        plugins: function () {
            UsuarioForm.validacaoForm();
        },
        bloquearCpf: function () {
            if ($('[name="id"]').val()) {
                $('[name="cpf"]').attr('readonly', true);
            }
        },
        validarCpf: function (cpf) {
            if (!cpf) return false;

            $.post(constants.SITE_PATH + '/usuarios/validar-cpf', {cpf: cpf}, function (response) {
                const $cpf = $('input[name="cpf"]');
                if (response.usuario) {
                    Notifica.info('Carregando dados, aguarde...');
                    setTimeout(() => {
                        window.location.href = constants.URL + '/alterar/' + response.usuario.slug_id;
                    }, 1500)
                    return false;
                }
            });
        },
        validacaoForm: function () {
            const $form = $(".form-usuario.form-validate");
            let configuracoesAdicionais = {
                rules: {
                    email: {
                        email: true
                    }
                },
                submitHandler: function (form) {
                    const quantidadePerfisAtribuidos = $('.tabela-perfis-atribuidos').find('.perfil-atribuido').length

                    if (quantidadePerfisAtribuidos === 0) {
                        Notifica.erro('Favor adicionar no mínimo um perfil para o usuário.', 'Validação!');
                        $('.tabbable a[href="#perfis"]').tab('show');
                        return false;
                    }

                    const $submit = $(form).find('[type="submit"]');
                    if ($submit.length) {
                        $submit.attr('disabled', true);
                    }

                    const $dropDownToggle = $(form).find('button.dropdown-toggle');
                    if ($dropDownToggle.length) {
                        $dropDownToggle.attr('disabled', true);
                    }

                    return true;
                }
            };

            configuracoesAdicionais = $.extend(Config.formValidator, configuracoesAdicionais);

            $form.validate().destroy();
            $form.validate(configuracoesAdicionais);
        },
        removerSituacao: function (url) {
            $.get(url, function (response) {
                if (response.data) {
                    $('tr[data-situacao-id="' + response.data + '"]').remove();
                    Notifica.sucesso('Situação removida do usuário com sucesso.');
                }
            }).fail(function () {
                Notifica.erro('Houve um erro ao remover a situação, contate o suporte técnico.');
            });
        }
    };

    // Inicializa o controle do form
    UsuarioForm.init();
});
