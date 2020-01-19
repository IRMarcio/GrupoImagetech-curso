var CarregaSecoes;

$(function () {
    CarregaSecoes = {
        init: function () {
            // CarregaSecoes.binds();
        },
        binds: function () {
            $('.carregar-secoes').change(function (e) {
                CarregaSecoes.carregar(this);
            });
        },
        carregar: function (select) {
            var id = $(select).find('option:selected').val(),
                $secoes = $('select[name="' + $(select).data('target') + '"]');

            var arrParams = [];
            arrParams.push('paginar=0');
            arrParams.push('unidade_id=' + id);

            var url = constants.SITE_PATH + '/unidades/secoes?' + arrParams.join('&');

            if (!id) {
                $secoes.empty();
                $secoes.append($('<option>', {
                    value: null,
                    text: null
                }));

                return;
            }

            $secoes.loading();
            $.post(url, function (retorno) {
                var secoes = retorno.data;

                $secoes.loading(false).empty();
                $secoes.append($('<option>', {
                    value: null,
                    text: null
                }));

                _.each(secoes, function (secao) {
                    var $option = '<option value="' + secao.id + '">' + secao.descricao + '</option>';
                    $secoes.append($option);
                });

                if ($secoes.attr('temp-value')) {
                    $secoes.val($secoes.attr('temp-value'));
                    $secoes.trigger('change');
                    $secoes.attr('temp-value', '');
                }

                $('body').trigger('secoesCarregadas');
            });
        }
    };

    CarregaSecoes.init();
});
