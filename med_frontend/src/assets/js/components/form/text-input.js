const ComponentTextInput = (function () {
    let option;

    const inputFocusoutHandler = (elem) => {
        validateItem(elem, true);
    }
    const inputFocusHandler = (elem) => {
        clearError(elem);
    }

    const init = (jqWrapElem, optionArr) => {
        option = optionArr;
        const currentInput = jqWrapElem.find('.js-field-input')
        currentInput.on('focusout', function (e) {
            e.preventDefault();
            inputFocusoutHandler($(this))
        });
        currentInput.on('focus', function (e) {
            e.preventDefault();
            inputFocusHandler($(this))
        });
    }

    const showError = (input, errorMessage) => {
        const inputWrapper = input.closest('.js__textinput');
        const errorElem = inputWrapper.find('.js-field-error');
        errorElem.text(errorMessage);
        inputWrapper.addClass('_invalid');
    }

    const clearError = (input) => {
        const inputWrapper = input.closest('.js__textinput');
        const errorElem = inputWrapper.find('.js-field-error');
        inputWrapper.removeClass('_invalid');
        input.removeClass('is-invalid');
        errorElem.text('')
    }

    const validate = (inputWrapper) => {
        let errorArray = []
        inputWrapper.each(function () {
            const errors = validateItem($(this).find('.js-field-input'), true);
            errorArray = errorArray.concat(errors);
        });
        return errorArray;
    }

    const validateItem = (input, isShowError) => {
        const inputWrapper = input.closest('.js__textinput');
        let errorMessage = '';
        let errors = [];
        if (inputWrapper.hasClass('is-required') && input.val() === "") {
            errorMessage = 'Required field';
            errors.push(errorMessage)
            if (isShowError) {
                clearError(input);
                showError(input, errorMessage);
            }
        }
        return errors
    }
    return {
        init: init,
        validate: validate,
        showError: showError,
    }
})();

export default ComponentTextInput