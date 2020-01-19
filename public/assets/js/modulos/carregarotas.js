let CarregaRotas;

$(function () {
    CarregaRotas = {
        init: function () {
            CarregaRotas.binds();
        },
        binds: function () {
            $('.carregar-rotas').change(function (e) {
                CarregaRotas.carregar(this);
            });
        },
        carregar: function (select) {
            var id = $(select).find('option:selected').val(),
                $rotas = $('select[name="' + $(select).data('target') + '"]'),
                url = constants.SITE_PATH + '/nucleo/modulos/rotas/' + id;

            if (!id) {
                $rotas.empty();
                $rotas.append($('<option>', {
                    value: null,
                    text: null
                }));

                return;
            }

            $rotas.loading();
            $.post(url, function (retorno) {
                const rotas = retorno.data;

                $rotas.loading(false).empty();
                $rotas.append($('<option>', {
                    value: null,
                    text: null
                }));

                _.each(rotas, function (rota) {
                    $rotas.append($('<option>', {
                        value: rota.id,
                        text: rota.descricao
                    }));
                });

                if ($rotas.attr('temp-value')) {
                    $rotas.val($rotas.attr('temp-value'));
                    $rotas.trigger('change');
                    $rotas.attr('temp-value', '');
                }

                $('body').trigger('rotasCarregados');
            });
        }
    };

    CarregaRotas.init();
});
