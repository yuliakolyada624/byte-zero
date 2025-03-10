/**
 * Show hidden elements as modals, popups, tooltips, etc.
 * In a first load webpage html elements loads before styles. That's all
 * elements with transition is jumping on a page.
 * @type { NodeListOf<HTMLElement> }
 * */
import Swiper from "swiper"
import { Navigation } from "swiper/modules"
import TelInput from "./components/tel-input/tel-input"
import { Header } from "./modules/landing/header"
import { FAQAccordion } from "./modules/landing/accordion"
import { FeedbackForm } from "./modules/landing/feedback-form"
import { FeedbackTarget } from "./modules/landing/feedback-target"
import { HeaderLinksScroll } from "./modules/landing/header-link-scroll"
import { HeaderNavigation } from "./modules/landing/header-nav"
import { SearchFilter } from "./modules/search-filter"
import ComponentDropdownSelect2 from "./components/form/dropdown-select2"
import ComponentTermsCheckbox from "./components/form/terms-checkout"
import ComponentSecurityCode from "./components/form/security-code"
import ComponentTextInput from "./components/form/text-input"
import ComponentItiDropdown from "./components/form/iti-dropdown"
import { CasesIntegration } from "./modules/cases/cases"
import { updateTotalResults } from "./global-functions";
import { TransactionsIntegration } from "./modules/transactions/transactions"
import { UserManagementIntegration } from "./modules/users/user-management"
import { uploadFileField } from "./modules/medical-chronology-request/file-upload"
import { MedicalChronologyForm } from "./modules/medical-chronology-request/medical-chronology-form"
import ComponentAutocomplete from "./components/form/autocomplete";
import ComponentDateRangeFilter from "./components/filter-daterange";
import AddonTooltips from "./components/tooltips"
import { ProfileEditForm } from "./modules/users/profile-edit-form"
import { EditUserOffcanvas } from "./modules/users/sidebars/edit-user__offcanvas"
import { JobTitleIntegration } from "./modules/users/job-title"
import { cardInputMask, inputNumber, resetFormInputs } from "./components/form/card-input"
import { OverviewIntegration } from "./modules/ overview/overview"


$(document).ready(function() {
    console.log("jQuery is working!");

    $('.js-additional-btn.show-pass').on('click', function(e) {
        console.log('click kk');
        e.preventDefault();
        $(this).toggleClass('showed');
        let input = $(this).closest('.form-field__input-wrap').find('.js-field-input');
        if (input.attr("type") === 'password') {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    $(document).on('click', '[data-bs-toggle="offcanvas"]', function () {
        var targetCanvasId = $(this).attr('data-bs-target');
        var returnTarget = $(this).attr('data-bs-return');
        var $canvas = $(targetCanvasId);
        var $backButton = $canvas.find('.offcanvas-title button');

        if ($backButton.length > 0 && returnTarget) {
            if (returnTarget === 'close') {
                $backButton.attr('data-bs-target', '');
                $backButton.attr('aria-controls', '');
                $backButton.removeAttr('data-bs-toggle');
            } else if (returnTarget.startsWith('#')) {
                $backButton.attr('data-bs-target', returnTarget);
                $backButton.attr('aria-controls', returnTarget.replace('#', ''));
                $backButton.attr('data-bs-toggle', 'offcanvas');
                $backButton.removeAttr('aria-label');
                $backButton.removeAttr('data-bs-dismiss');
            }
        }
    });


    // select all checkbox
    $('#select-all').click(function(event) {
        if(this.checked) {
            // Iterate each checkbox
            $('.user').each(function() {
                this.checked = true;
            });
        } else {
            $('.user').each(function() {
                this.checked = false;
            });
        }
    });

    $('.js-field-input[name="password"]').on('input', function(e) {
        //console.log('test password')
        checkValidationPasswordRules(this)
    });

    function checkValidationPasswordRules(input) {
        let form = $(input).closest('.js-form')
        if (!form || !input) return;

        const value = $(input).val();
        const lengthCheck = value.length >= 8;
        const uppercaseCheck = /[A-Z]/.test(value);
        const numberCheck = /\d/.test(value);

        const rulesList = form.find(".js-validation-item");

        const showValidationList = () => {
            $('.js__password-recommendation').addClass('d-none')
            $('.js__password-validation_list').removeClass('d-none');
        }

        const hideValidationList = () => {
            $('.js__password-validation_list').addClass('d-none');
            $('.js__password-recommendation').removeClass('d-none')
        }

        if (value) {
            showValidationList();
        } else {
            hideValidationList();
        }

        if (rulesList.length) {
            rulesList.each(function () {
                const validationType = $(this).data("validation");
                let isValid = false;

                switch (validationType) {
                    case 'length':
                        isValid = lengthCheck;
                        break;
                    case 'uppercase':
                        isValid = uppercaseCheck;
                        break;
                    case 'number':
                        isValid = numberCheck;
                        break;
                }

                $(this).toggleClass("valid", isValid);
            });
        }
    }


    ComponentSecurityCode.init()

    ComponentTextInput.init($('.form-field'));

    ComponentTermsCheckbox.init();

    ComponentDropdownSelect2.init($('.component__dropdown2'));

    ComponentItiDropdown.init($('.component__itidropdown'));

    ComponentAutocomplete.init($('.component__autocomplete'));

    ComponentDateRangeFilter.init($('.filter-daterange'));

    AddonTooltips.init('.jsAddon__tooltip');

    inputNumber() // init inputs only with numbers
    cardInputMask() // init mask for card inputs

    //landing
    const headerNavigationTrigger = document.querySelector(".js-header-menu-trigger")
    if (headerNavigationTrigger) {
        new HeaderNavigation(headerNavigationTrigger)
    }

    const isHomePage = document.querySelector(".js-index-page")
    if (isHomePage) {
        new HeaderLinksScroll(isHomePage)
    }

    const feedbackTrigger = document.querySelector(".js-feedback-trigger")
    if (feedbackTrigger) {
        new FeedbackTarget(feedbackTrigger)
    }


    const accordionWrap = document.querySelector(".js-faq-section-accordion")
    if (accordionWrap) {
        new FAQAccordion(accordionWrap)
    }


    const feedbackForm = document.querySelector(".js-feedback-section-form")
    if (feedbackForm) {
        new FeedbackForm(feedbackForm)
    }
    const fixedHeader = document.querySelector(".landing-header.js-fixed-header")
    if (fixedHeader) {
        new Header()
    }

    const swiperEl = document.querySelector(".swiper")
    if (swiperEl) {
        new Swiper(".swiper", {
            modules: [Navigation],
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            slidesPerView: 1,
        })
    }
    // end lending

    // Cases page
    const CasesTabContent = document.querySelector("#CasesTabContent")
    if (CasesTabContent) {
        new CasesIntegration()
        updateTotalResults();
    }

    // Transactions page
    const transactionsPage = document.querySelector("#transactionsPage")
    if (transactionsPage) {
        new TransactionsIntegration()
        updateTotalResults();
    }

    // User Management page
    const userManagementPage = document.querySelector("#userManagementPage")
    if (userManagementPage) {
        new UserManagementIntegration()
        updateTotalResults();
    }

    // Profile form
    const profileForm = $('.js__profile-form');
    if (profileForm.length) {
        new ProfileEditForm();
    }

    const editUserDetail = $('.edit-user-details__offcanvas')
    if (editUserDetail.length) {
        new EditUserOffcanvas();
    }


    // Edit Job Title
    const editJobTitle = document.querySelector("#EditJobTitle")
    if (editJobTitle) {
        new JobTitleIntegration()
    }

    const overViewResentCases = document.querySelector("#OverviewResentCasesTabContent")
    if (overViewResentCases) {
        new OverviewIntegration()
    }

});

window.addEventListener("load", async () => {

    // search filters init
    const searchContainers = document.querySelectorAll(".js-search-filter")
    searchContainers && searchContainers.forEach((container) => new SearchFilter(container))

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    // medcial chronology form
    // upload file
    const medicalSection = document.querySelector(".js-medical-chronology-request-section")
    let medicalchronologyInstance
    if (medicalSection) {
        medicalchronologyInstance = new MedicalChronologyForm(medicalSection)
    }
    const uploadInputs = document.querySelectorAll(".js-upload-file-input")
    if (uploadInputs && uploadInputs.length) {
        uploadInputs.forEach((input) => new uploadFileField(input, medicalchronologyInstance))
    }

    const zoomControl = document.querySelector("#zoom");
    const content = document.querySelector("#myiframe");
    if (zoomControl) {
        const updateZoom = () => {
            content.style = `--zoom-level: ${zoomControl.value}`;
        };
        zoomControl.addEventListener("change", updateZoom);
    }

   /* let today = new Date();
    let dd = today.getDate();
    let mm = today.getMonth()+1;
    let yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd
    }
    if(mm<10){
        mm='0'+mm
    }

    today = yyyy+'-'+mm+'-'+dd;
    document.getElementById("medical_chronology_request_plaintiff_date_of_incident").setAttribute("max", today);
    document.getElementById("medical_chronology_request_plaintiff_date_of_birth").setAttribute("max", today);*/

})

