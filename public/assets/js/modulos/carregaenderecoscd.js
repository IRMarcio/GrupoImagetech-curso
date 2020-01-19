var CarregarEnderecos;

$(function () {
    CarregarEnderecos = {
        init: function () {
            CarregarEnderecos.binds();
        },
        binds: function () {
            $('.carregar-enderecos').change(function (e) {
                CarregarEnderecos.carregar(this);
            });
        },
        carregar: function (select) {

            var id = $(select).find('option:selected').val(),
                $endereco = $('select[name="end_centro_id"]');

            $endereco.select2(
                    {
                        placeholder: 'buscando dados endereços...',
                        allowClear: true
                    }
                );
            var arrParams = [];
            arrParams.push('paginar=0');
            arrParams.push('unidade_id=' + id);

            var url = constants.SITE_PATH + '/centro-distribuicao/enderecos?' + arrParams.join('&');

            if (!id) {
                $endereco.empty();
                $endereco.append($('<option>', {
                    value: null,
                    text: null
                }));
                return;
            }

            $endereco.loading();

            $.post(url, function (retorno) {
                var enderecos = retorno.data;
                $endereco.loading(false).empty();
                $endereco.append($('<option>', {
                    value: -1,
                    text: 'Selecione...'
                }));

                if (enderecos.length === 0) {
                    Notifica.warning('Centro de Distribuiçao não localizado, Entre em contato com Departamento de TI');
                }

                _.each(enderecos, function (endereco) {
                    var $option = '<option value="' + endereco.id + '">' + endereco.area + '-' + endereco.rua + '-' + endereco.modulo + '-' + endereco.nivel + '-' + endereco.vao + '</option>';
                    $endereco.append($option);
                });

                if ($endereco.attr('temp-value')) {
                    $endereco.val($endereco.attr('temp-value'));
                    $endereco.trigger('change');
                    $endereco.attr('temp-value', '');
                }

                $('body').trigger('enderecosCarregadas');
            });
        }
    };

    CarregarEnderecos.init();
});
