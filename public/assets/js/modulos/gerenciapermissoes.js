$(function () {
    var url = constants.SITE_PATH + '/permissoes';

    $.post(url, function (retorno) {
        var view = retorno.data;

        $('#permissoes').html(view);
        $('.styled').uniform();
    });

    $('body').on('click', '.permitir-todos', function (e) {
        e.preventDefault();

        var $checkboxes = $(this).parents('.table').find(':checkbox');
        $checkboxes.prop('checked', true);
        $.uniform.update($checkboxes);
    });

    $('body').on('click', '.desmarcar-todos', function (e) {
        e.preventDefault();
        var $checkboxes = $(this).parents('.table').find(':checkbox');
        $checkboxes.prop('checked', false);
        $.uniform.update($checkboxes);
    });
});
