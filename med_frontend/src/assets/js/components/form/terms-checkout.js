const ComponentTermsCheckbox = (function () {
    const termCheckboxWrapper = $('.form-terms-checkbox');
    const termCheckboxInput = termCheckboxWrapper.find('.js__terms-checkbox');

    let errorMessage = '';
    let errors = [];

    const inputClickHandler = (elem) => {
        validate(elem, true);
    }

    const init = () => {
        termCheckboxInput.on('click', function (e) {
            clearError($(this));
            inputClickHandler($(this))
        });
    }

    const showError = () => {
        termCheckboxInput.addClass('is-invalid');
    }

    const clearError = () => {
        termCheckboxInput.removeClass('is-invalid');
    }

    const validate = (input) => {
        if (termCheckboxWrapper.hasClass('is-required') && !input.is(':checked')) {
            errorMessage = 'Required field';
            errors.push(errorMessage)
            showError();
        } else {
            clearError(input);
        }
        return errors;
    }
    return {
        init: init,
        validate: validate
    }

})();

export default ComponentTermsCheckbox;