import ComponentFormWrapper from "../../../components/form/form";
import { Toast } from "../../../components/toast";
import { getCSRFToken } from "../../../global-functions";

export class EditUserOffcanvas {
    constructor () {
        $('.js__edit-user-btn-submit').on('click', () =>  {
            const form = $('.offcanvas__edit-user-from');
            if (ComponentFormWrapper.validate(form)) {
                this.sendForm(form, this.getFormData(form));
            } else {
                new Toast({ position: ".offcanvas-end.show .offcanvas-header", text: "Validation error", type: 'error' })
            }
        });

        $(".js__load-edit-user-offcanvas").on('click', function (e) {
            const currentElem = $(this);
            const url = currentElem.data('url');
            const userId = currentElem.data('uid');
            const offcanvasBody = $(currentElem.data('bs-target')).find('#offcanvasEditUserDetailsBody');
            if (url && userId) {
                $.ajax({
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': getCSRFToken()
                    },
                    method: 'POST',
                    data: { user_id: userId },
                    success: function (response) {
                        offcanvasBody.replaceWith(response.offcanvasContent);
                        ComponentFormWrapper.init($('.offcanvas__edit-user-from'));
                        new EditUserOffcanvas();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        });
    }

    getFormData = (formElem) => {
        const formData = new FormData();

        const phoneInputItiInstance = formElem.find("#userEditOffcanvasPhone").data("iti");
        const phoneMobileInputItiInstance = formElem.find("#userEditOffcanvasMobilenumber").data("iti");

        formData.append("user_id", formElem.find("#userEditOffcanvasUserId").val());
        formData.append("first_name", formElem.find("#userEditOffcanvasFistName").val());
        formData.append("last_name", formElem.find("#userEditOffcanvasLastName").val());
        formData.append("email", formElem.find("#userEditOffcanvasEmail").val());
        formData.append("role", formElem.find("#userEditOffcanvasRole").val());
        formData.append("phone_number", phoneInputItiInstance.getNumber());
        formData.append("mobile_number", phoneMobileInputItiInstance.getNumber());
        formData.append("employee_id", formElem.find("#userEditOffcanvasEmployeeId").val());
        formData.append("job_title", formElem.find("#userEditOffcanvasJobTitle").val());
        formData.append("office_name", formElem.find("#userEditOffcanvasOfficeName").val());

        return formData;
    }

    sendForm = (formElem, formData) => {
        const formUrl = formElem.data('action');
        const canvas = formElem.data('canvas');

        $.ajax({
            url: formUrl,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": getCSRFToken(),
            },
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: (data) => {
                ComponentFormWrapper.showErrors($('.offcanvas__edit-user-from'), data)
                $(canvas).replaceWith(data.canvas);
                new Toast({ position: ".offcanvas-end.show .offcanvas-header", text: "1 user suspended!", type: 'successful' })
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error("Error:", textStatus, errorThrown);
                ComponentFormWrapper.showErrors($('.offcanvas__edit-user-from'), jqXHR.responseJSON.messages)
                new Toast({ position: ".offcanvas-end.show .offcanvas-header", text: "Validation error", type: 'error' })
            },
        });
    }
}