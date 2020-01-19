var CarregaPerfis;

$(function () {
    CarregaPerfis = {
        init: function () {
            CarregaPerfis.binds();
        },
        binds: function () {
            $('.carregar-perfis').change(function (e) {
                CarregaPerfis.carregar(this);
            });
        },
        carregar: function (select) {
            var id = $(select).find('option:selected').val(),
                $perfis = $('select[name="' + $(select).data('target') + '"]');

            var arrParams = [];
            arrParams.push('paginar=0');
            arrParams.push('unidade_id=' + id);

            if ($perfis.data('ativo') !== undefined) {
                arrParams.push('ativo=' + $perfis.data('ativo'));
            }

            var url = constants.SITE_PATH + '/perfis?' + arrParams.join('&');

            if (!id) {
                $perfis.empty();
                $perfis.append($('<option>', {
                    value: null,
                    text: null
                }));

                return;
            }

            $perfis.loading();
            $.post(url, function (retorno) {
                var perfis = retorno.data;

                $perfis.loading(false).empty();
                $perfis.append($('<option>', {
                    value: null,
                    text: null
                }));

                _.each(perfis, function (perfil) {
                    var $option = '<option value="' + perfil.id + '">' + perfil.nome + '</option>';
                    $perfis.append($option);
                });

                if ($perfis.attr('temp-value')) {
                    $perfis.val($perfis.attr('temp-value'));
                    $perfis.trigger('change');
                    $perfis.attr('temp-value', '');
                }

                $('body').trigger('perfisCarregados');
            });
        }
    };

    CarregaPerfis.init();
});
