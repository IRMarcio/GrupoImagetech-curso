/**
 * Configura o plugin date range picker
 */
export const dateRangePicker = {
    ranges: {
        'Hoje': [moment(), moment()],
        'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últ. 7 dias': [moment().subtract(6, 'days'), moment()],
        'Este mês': [moment().startOf('month'), moment().endOf('month')],
        'Últ. mês': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
    ,
    opens: 'right',
    buttonClasses: ['btn'],
    applyClass: 'btn-small btn-default btn-block',
    cancelClass: 'btn-small btn-default btn-block',
    locale: {
        applyLabel: 'Selecionar',
        fromLabel: 'De',
        toLabel: 'Até',
        customRangeLabel: 'Personalizar',
        daysOfWeek: ['Do', 'Se', 'Te', 'Qa', 'Qu', 'Se', 'Sa'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        firstDay: 1
    }
};

/**
 * Configura o plugin date picker
 */
export const datepicker = {
    format: "dd/mm/yyyy",
    startView: 1,
    maxViewMode: 0,
    todayBtn: true,
    multidate: false,
    autoclose: true,
    todayHighlight: true,
    language: "pt-BR",
};

/**
 * Configura o plugin que valida os formularios do sistema.
 */
export const formValidator = {
    ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
    errorClass: 'validation-error-label',
    successClass: 'validation-valid-label',
    highlight: function (element, errorClass) {
        $(element).removeClass(errorClass);
    },
    unhighlight: function (element, errorClass) {
        $(element).removeClass(errorClass);
    },
    errorPlacement: function (error, element) {
        if ($(element).prev().attr('class') === 'input-group-addon' && $(element).parents('.form-group').find('.validation-error-label:visible').length) {
            return;
        }

        if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container')) {
            if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo(element.parent().parent().parent().parent());
            }
            else {
                error.appendTo(element.parent().parent().parent().parent().parent());
            }
        }

        // Unstyled checkboxes, radios
        else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
            error.appendTo(element.parent().parent().parent());
        }

        // Input with icons and Select2
        else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
            if (element.parents('div').hasClass('input-group')) {
                error.appendTo(element.parent().parent());
            } else {
                error.appendTo(element.parent());
            }
        }

        // Inline checkboxes, radios
        else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
            error.appendTo(element.parent().parent());
        }

        // Input group, styled file input
        else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
            error.appendTo(element.parent().parent());
        }

        else {
            error.insertAfter(element);
        }
    },
    invalidHandler: function (e, validator) {
        if ($(this).find('.tabbable').length) {
            if ($(validator.errorList[0].element).closest(".tab-pane") && $(validator.errorList[0].element).closest(".tab-pane").attr('id')) {
                $('.tabbable a[href="#' + $(validator.errorList[0].element).closest(".tab-pane").attr('id') + '"]').tab('show');
            }
        }
    },
    validClass: "validation-valid-label",
    submitHandler: function (form, event) {
        if (event.isDefaultPrevented()) {
            return;
        }

        const $submit = $(form).find('[type="submit"]');
        if ($submit.length) {
            $submit.attr('disabled', true);
        }

        const $dropDownToggle = $(form).find('button.dropdown-toggle');
        if ($dropDownToggle.length) {
            $dropDownToggle.attr('disabled', true);
        }

        return true;
    }
};
