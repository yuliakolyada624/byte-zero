import intlTelInput from "intl-tel-input/intlTelInputWithUtils"
import Inputmask from 'inputmask';

const ComponentItiDropdown = (function () {
    let option;

    const inputFocusoutHandler = (elem) => {
        validateItem(elem, true);
    }
    const inputFocusHandler = (elem) => {
        clearError(elem);
    }

    const init = (jqWrapElem, optionArr) => {
        option = optionArr;

        const currentItiWrap = jqWrapElem;
        const currentItiInput = currentItiWrap.find('.js__itidropdown-input');

        const currentCountry = currentItiInput.data('country');

        currentItiInput.each(function (index) {

            const iti = intlTelInput(this, {
                onlyCountries: ["us", "ca", "ua"], // UA only for testing
                countryOrder: ["us", "ca", "ua"],
                initialCountry: "us",
                separateDialCode: true,
                countrySearch: false,
                hiddenInput: function (telInputName) {
                    return {
                        phone: "phone_full",
                        country: "country_code"
                    };
                }
            });

            $(this).data('iti', iti);

            if (currentCountry) {
                iti.setCountry(currentCountry);
            } 

            // const input = document.querySelector('#phone');
            // const iti = intlTelInput.getInstance(input);
            // iti.setCountry('ca');
            // iti.setNumber('2343242342');

            Inputmask({
                mask: "999-999-9999",
                placeholder: '',
                removeMaskOnSubmit: true,
                showMaskOnHover: false,
                showMaskOnFocus: false,
            }).mask(this);
        })

        currentItiInput.on('focusout', function (e) {
            e.preventDefault();
            inputFocusoutHandler($(this))
        });
        currentItiInput.on('focus', function (e) {
            e.preventDefault();
            inputFocusHandler($(this))
        });
    }

    const showError = (itiInput, errorMessage) => {
        const currentItiWrap = itiInput.closest('.component__itidropdown');
        const errorElem = currentItiWrap.find('.js-field-error');
        currentItiWrap.addClass('is-invalid');
        itiInput.addClass('is-invalid');
        errorElem.text(errorMessage);
    }

    const clearError = (itiInput) => {
        const currentItiWrap = itiInput.closest('.component__itidropdown');
        const errorElem = currentItiWrap.find('.js-field-error');
        currentItiWrap.removeClass('is-invalid');
        itiInput.removeClass('is-invalid');
        errorElem.text('')
    }

    const validate = (currentItiWrap) => {
        let errorArray = []
        currentItiWrap.each(function () {
            const errors = validateItem($(this).find('.js__itidropdown-input'), true)
            errorArray = errorArray.concat(errors);
        });
        return errorArray;
    }

    const validateItem = (itiInput, isShowError) => {
        const currentItiWrap = itiInput.closest('.component__itidropdown');
        let errorMessage = '';
        let errors = [];
        if (currentItiWrap.hasClass('is-required') && itiInput.val() === "") {
            errorMessage = 'Required field';
            errors.push(errorMessage)
            if (isShowError) {
                clearError(itiInput);
                showError(itiInput, errorMessage);
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

export default ComponentItiDropdown