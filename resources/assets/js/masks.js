/**
 * Registra as máscaras utilizadas nos inputs do sistema.
 */

export const registerMasks = (elemento) => {
    if (elemento == null) {
        elemento = $(document);
    }
    $(".mask-money").maskMoney({prefix: 'R$ ', allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});
    $('.mask-cpf', elemento).mask('000.000.000-00', {clearIfNotMatch: true});
    $('.mask-cnpj', elemento).mask('00.000.000/0000-00', {clearIfNotMatch: true});
    $('.mask-date', elemento).mask('00/00/0000', {clearIfNotMatch: true});
    $('.mask-cep', elemento).mask('00000-000', {clearIfNotMatch: true});
    $('.mask-inteiro', elemento).mask('0#');
    $('.mask-horario', elemento).mask('00:00', {clearIfNotMatch: true});
    $('.mask-decimal1').mask("#.##0,0", {reverse: true});
    $('.mask-mes-ano', elemento).mask('00-0000', {clearIfNotMatch: true});
    $('.mask-placa', elemento).mask('AAA-0000', {clearIfNotMatch: true});
    $('.mask-renavam', elemento).mask('00000000-0', {clearIfNotMatch: true});
    $('.mask-ano', elemento).mask('9999', {clearIfNotMatch: true});


    const SPMaskBehavior = (val) => (val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009'),
        spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };
    $('.mask-phone', elemento).mask(SPMaskBehavior, spOptions);
};
