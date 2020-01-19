var GerenciaPermissoes;

$(function () {
    GerenciaPermissoes = {
        init: function () {
            GerenciaPermissoes.binds();
            GerenciaPermissoes.plugins();
        },
        binds: function () {
            $('select[name="perfil_id"]').change(function () {
                GerenciaPermissoes.carregarPermissoes($(this));
            });
        },
        plugins: function () {
        },
        carregarPermissoes: function ($select) {
            var id = $select.val(),
                usuarioId = $('[name="usuario_id"]').val(),
                url = constants.SITE_PATH + '/permissoes?excecoes=1&perfil_id=' + id + '&usuario_id=' + usuarioId;

            if (!id || id == "") {
                return;
            }

            $select.loading();
            $.post(url, function (response) {
                var html = response.data;
                $('#permissoes').html(html);
                $select.loading(false);
                $('input[type="checkbox"]').uniform();
                $('.panel-footer').removeClass('hide');
            })
        }
    };

    // Inicializa o controle do form
    GerenciaPermissoes.init();
});
