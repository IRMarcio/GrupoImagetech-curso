var CarregarPerfisDaUnidade;

$(function () {
    CarregarPerfisDaUnidade = {
        init: function () {
            CarregarPerfisDaUnidade.binds();

            _.each($('.carregar-perfis-da-unidade'), function(select) {  
                CarregarPerfisDaUnidade.carregar(select, true);
            });
        },
        binds: function () {
            $('.carregar-perfis-da-unidade').change(function (e) {
                CarregarPerfisDaUnidade.carregar(this);
            });
        },
        carregar: function (selectUnidade, init) {
            init = init || false;

            var usId = $(selectUnidade).find('option:selected').val(),
                $perfis = $('select[name="' + $(selectUnidade).data('target') + '"]'),
                bloqueado = $perfis.attr('disabled'),
                url = constants.SITE_PATH + '/selecionar/buscar-perfis?unidade_id=' + usId;

            if (init && $perfis.find('option').length > 1) {
                return;
            }

            if (!usId) {
                $perfis.empty();
                $perfis.append($('<option>', {
                    value: null,
                    text: null
                }));

                return;
            }

            $perfis.loading();
            $.post(url, function (retorno) {
                var perfis = Array.isArray(retorno.data) ? retorno.data : Object.values(retorno.data);

                $perfis.loading(false).empty();
                $perfis.append($('<option>', {
                    value: null,
                    text: null
                }));

                perfis.map((funcao) => {
                    $perfis.append($('<option>', {
                        value: funcao.id,
                        text: funcao.nome
                    }))
                })

                if ($perfis.attr('temp-value')) {
                    $perfis.val($perfis.attr('temp-value'));
                    $perfis.trigger('change');
                    $perfis.attr('temp-value', '');
                }

                if (perfis.length == 1) {
                    $perfis.val(perfis[0].id);
                    $perfis.trigger('change');
                }

                if (bloqueado) {
                    $perfis.attr('disabled', bloqueado);
                }

                $('body').trigger('perfisDaUnidadeCarregados');
            });
        }
    };

    CarregarPerfisDaUnidade.init();
});
