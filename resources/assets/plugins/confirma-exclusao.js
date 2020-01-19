Vue.directive('confirma-exclusao', {
    bind: function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();

            const title = $(e.target).attr('data-title');
            const message = $(e.target).attr('data-message');

            sweetAlert({
                title:title || "Deseja mesmo fazer isso?",
                text:  message || 'Deseja mesmo excluir este registro?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '<i class="icon-cross3"></i> Não',
                confirmButtonText: '<i class="icon-check2"></i> Sim',
            }).then(function(result) {
                if (result.value) {
                    window.location.assign(el.href);
                }
            })

        });
    }
});
