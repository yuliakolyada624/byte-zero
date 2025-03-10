import ComponentDropdownSelect2 from "./dropdown-select2";
import ComponentItiDropdown from "./iti-dropdown";
import ComponentTextInput from "./text-input";

const ComponentFormWrapper = (function () {
    const init = (formElem) => {
        ComponentTextInput.init(formElem.find('.form-field'));
        ComponentDropdownSelect2.init(formElem.find('.component__dropdown2'));
        ComponentItiDropdown.init(formElem.find('.component__itidropdown'));
    }

    const validate = (formElem) => {
        let result = false;
        const formFieldsList = formElem.find('.js__component-of-form');
        formFieldsList.each(function () {
            result = validateField($(this)) || result;
        })
        return !result;
    }

    const validateField = (fieldElem) => {
        let errors = [];
        switch (true) {
            case fieldElem.hasClass('form-field'):
                errors = ComponentTextInput.validate(fieldElem);
                return !!(errors.length);
            case fieldElem.hasClass('component__dropdown2'):
                errors = ComponentDropdownSelect2.validate(fieldElem);
                return !!(errors.length);
            case fieldElem.hasClass('component__itidropdown'):
                errors = ComponentItiDropdown.validate(fieldElem);
                return !!(errors.length);
            default:
                return true;
        }
    }

    const showErrors = (form, data) => {
        console.log(data)
        const keys = Object.keys(data);
        keys.forEach(key => {
            const field = form.find(`[name="${key}"]`);
            switch (true) {
                case field.hasClass('form-field__input'):
                    ComponentTextInput.showError(field, data[key]);
                case field.hasClass('js__select2'):
                    ComponentDropdownSelect2.showError(field, data[key]);
                case field.hasClass('component__itidropdown-input'):
                    ComponentItiDropdown.showError(field, data[key]);
            }
        });
    }

    return {
        init: init,
        validate: validate,
        showErrors: showErrors
    }
})()

export default ComponentFormWrapper