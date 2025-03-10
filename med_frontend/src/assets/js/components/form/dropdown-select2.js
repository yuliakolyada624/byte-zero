const ComponentDropdownSelect2 = (function () {
    let option;

    const selectCloseHandler = (elem) => {
        validateItem(elem, true);
    }

    const updateStyle = (elem) => {
        const currentSelectWrap = elem.closest('.component__dropdown2');
        if (elem.val() !== '') {
            currentSelectWrap.addClass('has-value');
        } else {
            currentSelectWrap.removeClass('has-value');
        }
    }

    function formatState(state) {
        if (!state.id) {
            return state.text;
        }
        if (state.id == 'clear') {
            return $('<span class="option-clear-selection-btn">' + state.text + '</span>');
        }
        var color = $(state.element).data('color');
        if (color) {
            var $state = $(
                '<span><span style="background-color:' + color + '; width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 8px;"></span>' + state.text + '</span>'
            );
            return $state;
        } else {
            return state.text;
        }

    }

    const init = (jqWrapElem, optionArr) => {
        option = optionArr;

        const currentSelect = jqWrapElem.find('.js__select2');

        currentSelect.each(function() {
            const currentSelectWrap = $(this).closest('.component__dropdown2');

            const hasSearch = currentSelectWrap.data('search');

            clearError($(this));

            let options = {
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $(this).data('placeholder'),
                templateResult: formatState,
                templateSelection: formatState,
            }
            if (!hasSearch) {
                options = { ...options, minimumResultsForSearch: Infinity }
            }

            $(this).select2(options);

            $(this).on('change', function() {
                validateItem($(this))
                updateStyle($(this));
            });

            $(this).on('select2:selecting', function (e) {
                if (e.params.args.data.id === "clear") {
                    e.preventDefault();
                    $(this).val(null).trigger('change');
                    $(this).select2('close');
                }
            });

            $(this).on('select2:close', function () {
                selectCloseHandler($(this));
            });
        });
    }

    const showError = (select, errorMessage) => {
        const selectWrapper = select.closest('.component__dropdown2');
        const errorElem = selectWrapper.find('.js-field-error');
        select.addClass('is-invalid');
        errorElem.text(errorMessage);
    }

    const clearError = (select) => {
        const selectWrapper = select.closest('.component__dropdown2');
        const errorElem = selectWrapper.find('.js-field-error');
        select.removeClass('is-invalid');
        errorElem.text('')
    }

    const validate = (selectWrapper) => {
        let errorArray = []
        selectWrapper.each(function () {
            const errors = validateItem($(this).find('.js__select2'), true);
            errorArray = errorArray.concat(errors);
        });
        return errorArray;
    }

    const validateItem = (select, isShowError) => {
        const selectWrapper = select.closest('.component__dropdown2');
        let errorMessage = '';
        let errors = [];

        clearError(select);

        if (selectWrapper.hasClass('is-required') && !select.val()) {
            errorMessage = 'Required field';
            errors.push(errorMessage)
            if (isShowError) showError(select, errorMessage);
        }
        return errors
    }
    return {
        init: init,
        validate: validate,
        showError: showError,
    }
})();

export default ComponentDropdownSelect2;

