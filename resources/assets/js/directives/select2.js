export default {
    inserted(el, binding, vnode) {
        let multiple = $(el).attr('multiple');
        let data = $(el).attr('data-val');
        if (data) {
            data = JSON.parse(data);
        }

        let allowClear = $(el).attr('data-allow-clear');
        if (!allowClear) {
            allowClear = true;
        }

        const formataResultado = function (node, d) {
            if (node.level) {
                return $('<span style="padding-left:' + (20 * node.level) + 'px;">' + node.text + '</span>');
            }

            return node.text;
        };

        $(el).select2({
            data: data,
            templateResult: formataResultado,
            allowClear: allowClear,
            width: '100%',
            openOnEnter: false,
            theme: "bootstrap",
            language: "pt-BR",
            placeholder: "Selecione..."
        }).on(
            'select2:close',
            function (e) {
                $(this).focus();
            }
        ).on("select2:select select2:unselect", function (e) {
            if (e.type === 'select2:unselect' && !multiple) {
                e.target.value = '';
            }
            el.dispatchEvent(new Event('change', {target: e.target}));
        });
    },
    componentUpdated: function (el, binding, a) {
        if (el.value && binding.oldValue === binding.value) return;

        let selected = binding.value;
        if (typeof(selected) === "boolean") {
            selected = selected ? 1 : 0;
        }

        // Reconstroi o select2
        let select2Instance = $(el).data('select2');
        let resetOptions = select2Instance.options.options;
        resetOptions.disabled = a.elm.disabled;
        $(el).select2('destroy').select2(resetOptions);

        if (selected) {
            $(el).attr('temp-value', selected);
        }

        $(el).val(selected).trigger("change");
    },
}
