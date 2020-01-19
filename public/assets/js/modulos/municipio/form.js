var MunicipioForm;

$(function () {
    MunicipioForm = {
        init: function () {
            MunicipioForm.binds();
        },
        binds: function () {
            // controla cns e não possui cns
            $('input[name="ind_cep_unico"]').change(function (e) {
                MunicipioForm.ativaDesativaCep(!$(this).is(':checked'));
            });
        },
        ativaDesativaCep: function (bloquear) {
            var $cep = $('input[name="cep"]');
            $cep.attr('readonly', bloquear).focus();
            $cep.attr('required', true);
            if (bloquear) {
                $cep.val('');
                $cep.removeAttr('required');
            }
        }
    };

    MunicipioForm.init();
});