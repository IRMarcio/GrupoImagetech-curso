// Inicializa controle do index do usuário
let UsuarioIndex;

$(function () {
    UsuarioIndex = {
        init: function () {
            UsuarioIndex.binds();
        },
        binds: function () {
            const $document = $(document);

            // Rotina para invalidar a senha de vários registros da listagem de registros
            $('.acoes-com-registros-selecionados a.invalidar-senha-varios').on('click', function (e) {
                e.preventDefault()
                UsuarioIndex.invalidarSenhas($(this).attr('href'))
            });
        },
        invalidarSenhas: function (href) {
            var marcados = $('input[name="ids[]"]:checked')

            if (marcados.length === 0) {
                return;
            }

            var ids = [];
            marcados.each(function (i, id) {
                ids.push(id.value);
            })

            Sistema.confirmaAcao("Deseja mesmo invalidar a senha do(s) registro(s) selecionado(s)?", function () {
                $.post(href, {ids: ids}, function (retorno) {
                    if (retorno.sucesso) {
                        window.location.reload();
                    } else {
                        Notifica.erro('Houve um erro ao invalidar a senha de um ou mais registros.');
                    }
                }).fail(function () {
                    Notifica.erro('Houve um erro ao invalidar a senha de um ou mais registros.');
                })
            });
        },
    };

    // Inicializa o controle do form
    UsuarioIndex.init();
});
