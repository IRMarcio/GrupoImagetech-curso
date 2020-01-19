import pace from 'pace-progress';
import {formValidator as formValidatorConfig, datepicker} from "./defaultconfigs";


/**
 * Registra alguns plugins JQUERY que são utilizados em todo o sistema (ou em quase todo).
 */
export const registerPlugins = (elemento) => {
    if (elemento == null) {
        elemento = $(document);
    }

    select2(elemento);
    formValidate(elemento);
    styledCheckboxes(elemento);
    datePickers(elemento);
    styledLabelsForRequiredFields(elemento);

    pace.start();

    // Adiciona listener de mudança de atributo para estilizar/remover estilo de campo obrigatório
    $('input,select,textarea').attrchange({
        trackValues: false,
        callback: function (event) { 
            if (event.attributeName === 'required') {
                styledLabelIfRequiredField(event.target)
            }
        }        
    });

    // Listener no app inteiro para verificar adição/remoção de elementos de formulário
    const app = document.getElementById('app');
    const observer = new MutationObserver(function(mutations) {
        if ($(mutations[0].target).find('input,select,textarea').length) {
           styledLabelsForRequiredFields(elemento)
        }
    })
    observer.observe(app, {childList: true, subtree: true})
};

/**
 * Instancia o plugin do SELECT2 utilizado em alguns formulários.
 */
const select2 = (elemento) => {
    $('select.select2', elemento).not('.select2-hidden-accessible').select2({
        allowClear: true,
        width: '100%',
        openOnEnter: false,
        theme: "bootstrap",
        language: "pt-BR",
        placeholder: "Selecione..."
    }).on(
        'select2:close',
        function () {
            $(this).focus();
        }
    );
};


/**
 * Instancia o plugin de validação de formulários.
 */
const formValidate = (elemento) => {
    $(".form-validate", elemento).validate(formValidatorConfig);
};

/**
 * Instancia as checkbox e radios estilizados.
 */
const styledCheckboxes = (elemento) => {
    $(".styled, .multiselect-container input", elemento).uniform({
        radioClass: 'choice'
    });
};

/**
 * Inicia um ou mais datepickers.
 */
const datePickers = (elemento) => {
    $('.input-datepicker, .input-daterange', elemento).datepicker(datepicker);

    $('.input-datepicker-inline div', elemento).datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true,
        language: "pt-BR",
    });
};

/**
 * Aplica a class marked-required em todos os labels referentes
 * À campos obrigatórios de formulário 
 * Campos que contém o atributo required !== false
 */
const styledLabelsForRequiredFields = (elemento) => {
    $('.form-control', elemento).not('.not-styled-label').map((i, e) => {
        styledLabelIfRequiredField(e)
    })
};

const styledLabelIfRequiredField = (elemento) => {
    // Busca o label do elemento
    const tagName = $(elemento)[0].tagName
    const $label = tagName === 'SELECT' ? ($(elemento).parent('div').hasClass('input-group') ? $(elemento).parent('div').parent('div').find('label:first') : $(elemento).parent('div').find('label:first'))  : 
        $(elemento).parent('div').parent('div').find('label:first')

    // Se label não foi encontrado, retorna
    if ($label.length === 0) {
        return
    }

    // Verifica se elemento está marcado como obrigatorio
    const obrigatorio = $(elemento)[0].hasAttribute('required')

    // Se não for obrigatório, remove a class e o *
    if ( ! obrigatorio) {
        // Se label não tiver a class marked-required, retorna
        if ($label.hasClass('marked-required') === false) {
            return
        }

        // remove a class do label
        $label.removeClass('marked-required')

        // Retorna
        return
    }

    // Se tiver a class marked-required, retorna
    if ($label.hasClass('marked-required')) {
        return
    }

    // Adiciona class no label para identificar que o mesmo já está 
    // Identificado como obrigatório
    $label.addClass('marked-required')
}