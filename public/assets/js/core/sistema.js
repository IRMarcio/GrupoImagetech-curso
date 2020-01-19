$(function () {
    Sistema = {
        /**
         * Aplica alguns binds globais do sistema.
         */
        aplicarBindsGlobais: function () {
            // Checkbox que seleciona ou deseleciona
            $('.selecionar-todos-registros').on('click', function () {
                var target = $(this).attr('data-target'),
                    nome = "input[name='" + target + "']";

                $(nome).prop('checked', $(this).prop('checked'));
                $.uniform.update(nome);

                var marcados = $('input[name="ids[]"]:checked');
                Sistema.exibirEsconderBlocoAcoesComRegistrosSelecionados(marcados);
            });

            // Ao clicar em algum dos checkbox, mostra os botões de ações
            $('input[name="ids[]"]').on('click', function () {
                var marcados = $('input[name="ids[]"]:checked');
                Sistema.exibirEsconderBlocoAcoesComRegistrosSelecionados(marcados);
            })
        },

        exibirEsconderBlocoAcoesComRegistrosSelecionados: function (marcados) {
            var display = 'none';
            if (marcados.length > 0) {
                display = 'block';
            }

            $('.acoes-com-registros-selecionados').css('display', display);
        },

        confirmaAcao: function (texto, callbackSim, callbackNao) {
            bootbox.confirm({
                title: "Atenção",
                message: texto,
                buttons: {
                    cancel: {
                        label: '<i class="icon-cross3"></i> Não'
                    },
                    confirm: {
                        label: '<i class="icon-check2"></i> Sim'
                    }
                },
                callback: function (result) {
                    if (result) {
                        callbackSim()
                    } else {
                        if (callbackNao) {
                            callbackNao()
                        }
                    }
                }
            });
        },

        /**
         * Aplica os plugins necessários para o sistema funcionar corretamente.
         */
        aplicarPluginsExternos: function (elemento) {
            if (elemento == null) {
                elemento = $(document);
            }

            if ($.fn.dataTable) {
                $.extend($.fn.dataTable.defaults, {
                    pageLength: 5,
                    autoWidth: false,
                    searching: false,
                    lengthChange: false,
                    columnDefs: [{
                        targets: [0],
                        orderable: false
                    }],
                    order: [[1, 'asc']],
                    dom: '<"datatable-scroll"t><"datatable-footer"ip>',
                    language: {
                        "sEmptyTable": "Nenhum registro encontrado",
                        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                        "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sInfoThousands": ".",
                        "sLengthMenu": "_MENU_ resultados por página",
                        "sLoadingRecords": "Carregando...",
                        "sProcessing": "Processando...",
                        "sZeroRecords": "Nenhum registro encontrado",
                        "sSearch": "Pesquisar",
                        "oPaginate": {
                            "sNext": "Próximo",
                            "sPrevious": "Anterior",
                            "sFirst": "Primeiro",
                            "sLast": "Último"
                        },
                        "oAria": {
                            "sSortAscending": ": Ordenar colunas de forma ascendente",
                            "sSortDescending": ": Ordenar colunas de forma descendente"
                        }
                    }
                });
            }

            // Mostra um spinner ao lado do input para dizer que está carregando
            // TODO: ta feito pra caramba, refatorar para outro arquivo e modularizar melhor
            $.fn.loading = function (exibir) {
                var $formGroup = this.parents('.form-group'), $this = this;

                if (exibir || typeof exibir == 'undefined') {
                    this.attr('disabled', true);
                    this.prop('loading', true);
                    if (this.prop('tagName') == 'BUTTON') {
                        var $icone = this.find('i');

                        // Salva o icone original
                        this.data('icone-original', $icone.attr('class'));

                        // Remove as classes do icone atual
                        $icone.removeClass();

                        // Adiciona a nova classe para mostrar o loading
                        $icone.addClass('icon-spinner2 spinner position-left');
                        return;
                    }

                    if (this.prop('tagName') == 'SELECT') {
                        $formGroup.addClass('has-feedback-select2');
                    }

                    $formGroup.addClass('has-feedback');
                    $formGroup.append('<div class="form-control-feedback"><i class="icon-spinner2 spinner"></i></div>');
                } else {
                    setTimeout(function () {
                        $this.attr('disabled', false);
                        $this.prop('loading', false);
                        if ($this.prop('tagName') == 'BUTTON') {
                            var $icone = $this.find('i'),
                                iconeOriginal = $this.data('icone-original');

                            // Remove as classes do icone atual
                            $icone.removeClass();

                            // Coloca de volta a classe do icone original
                            $icone.addClass(iconeOriginal);
                            return;
                        } else {
                            $formGroup.removeClass('has-feedback');
                            $formGroup.removeClass('has-feedback-select2');
                            $formGroup.find('.form-control-feedback').remove();
                        }
                    });
                }

                return this;
            };
        },

        /**
         * Adicionar máscara de cpf na string informada.
         */
        formatarMascaraCpf: function (cpf) {
            var formatter = new StringMask('000.000.000-00');
            return formatter.apply(cpf);
        },
        /**
         * Adicionar máscara de cns na string informada.
         */
        formatarMascaraCns: function (cns) {
            var formatter = new StringMask('000 0000 0000 0000');
            return formatter.apply(cns);
        },
        /**
         * Formata data informada de en para pt.
         */
        formatarDataPt: function (data) {
            return moment(data, 'YYYY-MM-DD').format('DD/MM/YYYY');
        },

        // Converte numero 0.000,00 em formato float
        strToFloat: function(num) {
            var vlr = num;
            while (String(vlr).indexOf(".") != -1)
                vlr = String(vlr).replace(".","");
            vlr = String(vlr).replace(",",".");
            vlr = parseFloat(vlr);
            if (isNaN(vlr))
                vlr = 0;
            if (String(vlr).toLowerCase().indexOf('nan') > -1)
                vlr = 0;
            return vlr;
        },
        numberFormat: function(number, decimals, decPoint, thousandsSep) {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
            var n = !isFinite(+number) ? 0 : +number
            var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
            var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
            var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
            var s = ''
            var toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec)
            return '' + (Math.round(n * k) / k)
            .toFixed(prec)
            }

            // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
            if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
            }
            if ((s[1] || '').length < prec) {
            s[1] = s[1] || ''
            s[1] += new Array(prec - s[1].length + 1).join('0')
            }

            return s.join(dec)
        },
        colllapseHidePanel: function ($element) {
            var $panelCollapse = $element.parent().parent().parent().parent().nextAll();
            $element.parents('.panel').addClass('panel-collapsed');
            $element.addClass('rotate-180');

            containerHeight(); // recalculate page height

            $panelCollapse.slideUp(150);
        },

        colllapseShowPanel: function ($element) {
            var $panelCollapse = $element.parent().parent().parent().parent().nextAll();
            $element.parents('.panel').removeClass('panel-collapsed');
            $element.removeClass('rotate-180');

            containerHeight(); // recalculate page height

            $panelCollapse.slideDown(150);
        },

        /**
         * Inicia as funções.
         */
        init: function () {
            this.aplicarPluginsExternos();
            this.aplicarBindsGlobais();
        }
    };



    Sistema.init();
});
