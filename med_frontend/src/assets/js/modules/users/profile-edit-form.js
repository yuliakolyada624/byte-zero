import ComponentFormWrapper from "../../components/form/form";
import { Toast } from "../../components/toast";
import { getCSRFToken } from "../../global-functions";


export class ProfileEditForm {
    constructor () {
        const thisWrapper = this;
        $('.js__profile-form-country .js__select2').on('change', function(e) {
            const value = $(this).val();
            thisWrapper.rebuildStateSelect(value);
        });

        $('#profile_passperiod-input').on('change', function(e) {
            const value = $(this).is(':checked');
            thisWrapper.switchChangePasswordPeriodSelect(value);
        });

        $('.js__profile-form').on('submit', function(e) {
            thisWrapper.submitForms(e);
        });

        $('#jsProfileSendAllForms').on('click', function(e) {
            thisWrapper.submitForms(e);
        });

        $('#zip_code').inputmask({ mask: "99999[-9999]", placeholder: "_" });
    }

    switchChangePasswordPeriodSelect = (selectStatus) => {
        const periodSelect = $('.js__profile-form-passperiod .js__select2');
        periodSelect.select2('destroy');

        let options = {
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            minimumResultsForSearch: Infinity,
        }
        if (selectStatus) {
            $('.js__profile-form-passperiod').removeClass('disabled');
            periodSelect.prop('disabled', false);
        }
        else {
            $('.js__profile-form-passperiod').addClass('disabled');
            periodSelect.prop('disabled', false);
            options = { ...options, disabled: true}
        }
        periodSelect.select2(options);
    }

    rebuildStateSelect = (value) => {
        const stateSelect = $('.js__profile-form-state .js__select2');
        const zipPostalInput = $('#zip_code');
        if (value) {
            const zipMask = "99999[-9999]";
            const postalMask = "A9A 9A9";

            zipPostalInput.inputmask("remove");

            stateSelect.select2('destroy');
            stateSelect.html('');

            let options = [];
            if (value == 'US') {
                options = statesGlobal;
                zipPostalInput.inputmask({ mask: zipMask, placeholder: "_" });
            } 
            if (value == 'CA') {
                options = provincesGlobal;
                zipPostalInput.inputmask({ mask: postalMask, placeholder: "_" });
            }
            stateSelect.select2({
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $(this).data('placeholder'),
                minimumResultsForSearch: Infinity,
                placeholder: "Select",
                data: options
            })
        }
    }

    submitForms = (e) => {
        e.preventDefault();
        const profileForm = $('.js--profile-action');
        const passwordForm = $('.js--updatepass-action');

        // Profile
        const profileFormData = this.getProfileFormData(profileForm);
        // console.log(ComponentFormWrapper.validate($('.js__profile-form')));
        if (ComponentFormWrapper.validate($('.js__profile-form'))) {
            this.sendForm(profileForm, profileFormData);
        } else {
            new Toast({ position: ".header .justify-content-end", text: 'Please input validate info', type: 'error', class: 'page-toast' })
        }

        // Password
        const { passwordFormData, hasValue } = this.getPasswordFormData(passwordForm);
        if (hasValue) {
            this.sendForm(passwordForm, passwordFormData);
        }
    }

    getProfileFormData = (formElem) => {
        const formData = new FormData();
        
        const phoneInputItiInstance = formElem.find("#phone").data("iti");
        const phoneMobileInputItiInstance = formElem.find("#mobilenumber").data("iti");

        formData.append("first_name", formElem.find("#first_name").val());
        formData.append("last_name", formElem.find("#last_name").val());
        formData.append("employee_id", formElem.find("#employee_id").val());
        formData.append("job_title", formElem.find("#profileJobTitle").val());
        formData.append("phone_number", phoneInputItiInstance.getNumber());
        formData.append("mobile_phone", phoneMobileInputItiInstance.getNumber());

        formData.append("office_name", formElem.find("#office_name").val());
        formData.append("legal_entity_name", formElem.find("#legal_entity_name").val());
        formData.append("address_line_1", formElem.find("#address_line_1").val());
        formData.append("address_line_2", formElem.find("#address_line_2").val());
        formData.append("city", formElem.find("#city").val());
        formData.append("country_a2code", formElem.find("#country").val());
        formData.append("district", formElem.find("#district").val());
        formData.append("zip_code", formElem.find("#zip_code").val());

        formData.append("profile_passperiod_enable", (formElem.find("#profile_passperiod-input").is(':checked')));
        formData.append("pass_period", formElem.find("#passPeriod").val());

        formData.append("exclude_notifications_from_header", formElem.find("#deleteNotification").val());

        return formData;
    }

    getPasswordFormData = (formElem) => {
        const formData = new FormData();

        const current_password = formElem.find("#current_password").val();
        const password = formElem.find("#current_password").val();
        const password_confirm = formElem.find("#current_password").val();

        const hasValue = current_password || password || password_confirm;

        formData.append("id", formElem.find("#user_id").val());
        formData.append("current_password", current_password);
        formData.append("password", password);
        formData.append("password_confirm", password_confirm);

        return { formData, hasValue };
    }

    sendForm = (formElem, formData) => {
        const formUrl = formElem.data('action');

        $.ajax({
            url: SITEURL + formUrl,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": getCSRFToken(),
            },
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: (data) => {
                console.log(data);
                ComponentFormWrapper.showErrors($('.js__profile-form'), data)
                new Toast({ position: ".header .justify-content-end", text: 'Personal Profile updated!', type: 'successful', class: 'page-toast' })
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error("Error:", textStatus, errorThrown);
                ComponentFormWrapper.showErrors($('.js__profile-form'), jqXHR.responseJSON.messages)
                new Toast({ position: ".header .justify-content-end", text: 'Please input validate info', type: 'error', class: 'page-toast' })
            },
        });
    }
}
