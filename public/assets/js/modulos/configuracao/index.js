$(function () {

    $('#testar-email').on('click', function (e) {
        e.preventDefault();
        window.Notifica.bloquearTela("Testando conexão...");

        var dados = $('form[name="configuracoes"]').serializeArray();
        $.post(constants.SITE_PATH + '/configuracoes/testar-email', dados, function (retorno) {
            window.Notifica.desbloquearTela();

            Notifica.info(retorno);
        }).fail(function(e) {
            Notifica.erro("Não foi possível se conectar ao e-mail utilizando as credenciais fornecidas.");
        });
    })

});
