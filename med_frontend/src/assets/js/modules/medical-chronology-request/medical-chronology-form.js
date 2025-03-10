import { createDropdownData, createInputData } from "./helpers/_creators"
import { initDropdowns } from "./helpers/_init-dropdowns"
import { initInputs } from "./helpers/_init-inputs"
import { initSvgAreas } from "./helpers/_init-svg-areas"
import { initInjuriesPopups } from "./helpers/_init-injuries-popups"
import { getCSRFToken } from "../../global-functions";

export class MedicalChronologyForm {
  constructor(section) {
    this.section = section
    this.files = []

    this.inputs = [...section.querySelectorAll(".js-medical-chronology-request__input")].reduce(
      (obj, item) => ({ ...obj, [item.name]: createInputData(item) }),
      {},
    )
    this.dropdowns = [
      ...section.querySelectorAll(".js-medical-chronology-request__dropdown"),
    ].reduce((obj, item) => ({ ...obj, [item.dataset.name]: createDropdownData(item) }), {})

    this.selectedInjuriesList = section.querySelector(
      ".js-medical-chronology-request-selected-injuries-list",
    )

    this.bodyAreasCheckboxes = [...section.querySelectorAll(".js-injury-item-checkbox")]

    this.bodyAreas = section.querySelector(".js-human-body-areas-wrap")
    this.popups = [...section.querySelectorAll('.js-injury-popup-wrap')]
    this.submitBtn = section.querySelector(".js-medical-chronology-request-submit-btn")

    this.svgGroupAreas = section.querySelectorAll(".js-body-area")

    this.isInputsFilled = false
    this.isDropdownsSelected = false
    this.isBodyAreas = false

    this.isFormFilled = false

    this.#init()
  }

  checkisFormFilled() {
    if (this.isBodyAreas) {
      const isAnyCheck = this.bodyAreasCheckboxes.some((check) => check.checked)
      this.isFormFilled =
        Boolean(this.files.length) &&
        /*this.isInputsFilled &&*/
        this.isDropdownsSelected &&
        this.isBodyAreas &&
        isAnyCheck
    } else {
      console.log(this.files);
      console.log(this.files.length);
      console.log(this.isDropdownsSelected);
      this.isFormFilled =
        Boolean(this.files.length) && this.isDropdownsSelected
    }
    if (this.isFormFilled) {
      this.submitBtn.removeAttribute("disabled")
    } else {
      this.submitBtn.setAttribute("disabled", true)
    }
  }

  handleSubmit(event) {
    event.preventDefault(); // Prevent default form submission

    // Initialize a new FormData object
    const formData = new FormData();

    // Gather all inputs
    $(".js-medical-chronology-request-form-with-inputs :input").each(function() {
        const input = $(this);
        if(input.attr("name")===''|| input.attr("name")===undefined ){
          return;
        }
        if (input.attr("type") === "checkbox") {
            // Handle checkboxes (for injury areas)
            if (input.is(":checked")) {
                formData.append(input.attr("name"), input.val());
            }
        } else if (input.attr("type") === "radio") {
            // Handle radio buttons
            if (input.is(":checked")) {
                formData.append(input.attr("name"), input.val());
            }
        } else {
            // Handle all other input types
            formData.append(input.attr("name"), input.val());
            //console.log(input.attr("name"));
        }
    });

    // Additional data to submit
    formData.append("order_number", $("#medical-chronology-request-order-number").val());

    // Submit data using AJAX
    $.ajax({
      url: `${SITEURL}orders/save-medical-chronology-request`,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
          "X-CSRF-TOKEN": getCSRFToken(), 
        },
        success: function(response) {
            // Handle successful submission
            console.log("Form submitted successfully:", response);
            
            //window.location.href = `${SITEURL}orders/medical-chronology-review/` + response.order_id
            const form_section = $('.js-medical-chronology-request-section');
            form_section.hide();
            form_section.after(response.review_html);
            // scroll to top
            $('html, body').animate({ scrollTop: 0 }, 'slow');

        },
        error: function(xhr, status, error) {
            // Handle submission error
            console.error("Form submission failed:", error);
        },
    });
  }
  caseName() {
    medical_chronology_request_plaintiff_first_name.addEventListener('input', joinValues, false);
    medical_chronology_request_plaintiff_last_name.addEventListener('input', joinValues, false);
    defendant_first_name.addEventListener('input', joinValues, false);
    defendant_last_name.addEventListener('input', joinValues, false);
    defendant_company_name.addEventListener('input', joinValues, false);

  
    function joinValues(){
      medical_chronology_request_case_name.value = medical_chronology_request_plaintiff_first_name.value + ' ' + medical_chronology_request_plaintiff_last_name.value + ' vs. '+ defendant_first_name.value + ' '+ defendant_last_name.value + '  '+ defendant_company_name.value;
    }
  }

  #init() {
    console.log(this)
    initDropdowns(this.dropdowns, this)
    initInputs(this.inputs, this)
    initSvgAreas(this.svgGroupAreas, this)
    initInjuriesPopups(this.popups, this)
    this.submitBtn.addEventListener('click', this.handleSubmit)
    this.caseName()
  }

}

// case name input
