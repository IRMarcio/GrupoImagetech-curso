var CarregarMunicipios;

$(function () {
    CarregarMunicipios = {
        init: function () {
            CarregarMunicipios.binds();
        },
        binds: function () {
            $('.carregar-municipios').change(function (e) {
                CarregarMunicipios.carregar(this);
            });

        },
        carregar: function (selectUf) {
            var ufId = $(selectUf).find('option:selected').val(),
                $cidades = $('select[name="' + $(selectUf).data('target') + '"]'),
                bloqueado = $cidades.attr('disabled'),
                url = constants.SITE_PATH + '/municipios?paginar=0&uf_id=' + ufId;
            console.log(ufId, $cidades,url);

            console.log($cidades)

            if (!ufId) {
                $cidades.empty();
                $cidades.append($('<option>', {
                    value: null,
                    text: null
                }));

                return;
            }

            $cidades.loading();
            $.post(url, function (retorno) {
                var cidades = retorno.data;

                $cidades.loading(false).empty();
                $cidades.append($('<option>', {
                    value: null,
                    text: null
                }));

                _.each(cidades, function (cidade) {
                    $cidades.append($('<option>', {
                        value: cidade.id,
                        text: cidade.descricao
                    }));
                });

                if ($cidades.attr('temp-value')) {
                    $cidades.val($cidades.attr('temp-value'));
                    $cidades.trigger('change');
                    $cidades.attr('temp-value', '');
                }

                if (bloqueado) {
                    $cidades.attr('disabled', bloqueado);
                }

                $('body').trigger('municipiosCarregados');
            });
        }
    };

    CarregarMunicipios.init();
});
