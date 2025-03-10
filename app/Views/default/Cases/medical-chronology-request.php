<?= $this->extend('template/layout') ?>
<?= $this->section('content') ?>

<?= $this->section('extra-css') ?>
<style>
</style>
<?= $this->endSection() ?>

<?php
$user = auth()->user();
//dd($report_type);
$reportText = '';
switch ($report_type) {
    case 'medical_chronology':
        $reportText = 'Medical Chronology';
        break;
    case 'billing_summary':
        $reportText = 'Billing Summary';
        break;
    case 'medical_chronology_and_billing_summary':
        $reportText = 'Medical Chronology + Billing Summary';
        break;
    default:
        $reportText = 'Unknown Report Type'; // Optional fallback for unexpected values
        break;
}
?>

<section class="medical-chronology-request js-medical-chronology-request-section">
    <div class="medical-chronology-request-heading">
        <div class="d-flex align-items-center justify-content-between pb-2">
            <h1 class="mb-0">
                <?=$reportText?>
                Order</h1>
            <p class="fs-14">Order Number: <span id="user_order_number">Pending</span></p>
        </div>
    </div>
    <div class="medical-chronology-request-form-group">
        <p class="mb-3">Please fill out all sections of the form.</p>
        <form class="medical-chronology-request-form-upload-file js-upload-file-wrapper js-upload-file-form">
            <input type="hidden" name="report_type" id="report_type" value="<?=$report_type?>" />
            <input type="hidden" name="order_number" id="order_number" value="<?=$order_number?>" />
            <label class="medical-chronology-request-form-upload-file__field js-upload-file-preview">
                <input class="medical-chronology-request-form-upload-file__input js-upload-file-input"
                    type="file"
                    name="files[]"
                    multiple 
                    accept="application/pdf" 
                    data-max-size="5">
                <span class="medical-chronology-request-form-upload-file__loadicon">

                    <svg class="icon icon-upload ">
                        <use href="/assets/themes/default/icon/icons/icons.svg#upload" />
                    </svg>

                </span>
                <span class="medical-chronology-request-form-upload-file__title">
                    <b>Click to upload</b> or drag and drop PDF files of <b style="color:#131316">MEDICAL BILLS.</b> <br />
                    (e.g., hospital bills, specialist bills, surgical/procedure bills, etc.)
                </span>
            </label>
            <div class="medical-chronology-request-form-upload-file__loadbox js-upload-file-loadbox">
                <div class="medical-chronology-request-form-upload-file__loadbox-inner-wrap">
                    <div class="medical-chronology-request-form-upload-file__items js-upload-file-items"></div>
                    <div class="medical-chronology-request-form-upload-file__progress js-upload-file-progress-wrap">
                        <div class="medical-chronology-request-form-upload-file__progress-wrap">
                            <div class="medical-chronology-request-form-upload-file__progress-bar">
                                <div
                                    class="medical-chronology-request-form-upload-file__progress-bar-filled js-upload-file-progressline-fill">
                                </div>
                            </div>
                            <div
                                class="medical-chronology-request-form-upload-file__progress-count js-upload-file-progressline-counter">
                                0%</div>
                        </div>
                    </div>
                    <div class="files-counter-wrap">
                        <div class="d-flex">
                        <div class="files-counter">
                            <span>Exhibit count: </span><span class="counter total-exhibits">0</span>
                        </div>
                        <span class="separator">|</span>
                        <div>
                            <span>Page count:</span> <span class="counter total-pages">0</span>
                        </div>
                        <span class="separator">|</span>
                        <div class="costs">
                            <span>Cost:</span>
                            <span class="cost-amount">0</span>
                        </div>
                        </div>
                        <a href="#">View Service Fees
                        <svg class="icon icon-link-external ">
                            <use href="/assets/themes/default/icon/icons/icons.svg#link-external" />
                        </svg>
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <form class="js-medical-chronology-request-form-with-inputs row" method="post" id="medical-chronology-request">
            <input type="hidden" name="report_type" value="<?=$report_type?>" />
            <input type="hidden" name="medical_chronology_request_order_number" id="medical-chronology-request-order-number" value="" />

            <div class="form-field col-6  is-required js-field js__textinput " data-type="">
                <label for="medical_chronology_request_claim_number" class="form-label form-field__title">Claim
                    number*</label>
                <div class="form-field__input-wrap">
                    <input class="form-field__input js-field-input form-control"
                        id="medical_chronology_request_claim_number" validateOnBlur="true" type=""
                        name="medical_chronology_request_claim_number" value="" placeholder="" />
                </div>
                <span class="form-field__error js-field-error">Required field</span>
            </div>



            <div class="form-field col-6 is-readonly  js-field js__textinput " data-type="name">
                <label for="medical_chronology_request_case_name" class="form-label form-field__title">Case name</label>
                <div class="form-field__input-wrap">
                    <input class="form-field__input js-field-input form-control" id="medical_chronology_request_case_name"
                            validateOnBlur="" type="" name="medical_chronology_request_case_name" value="" placeholder=""
                            readonly />
                    <div class="form-field__readonly-symbol">
                        <svg class="icon icon-secure ">
                            <use href="/assets/themes/default/icon/icons/icons.svg#secure" />
                        </svg>
                    </div>
                </div>
            </div>



            <div class="form-field col-6 doi is-required js-field js__textinput " data-type="">
                <label for="medical_chronology_request_plaintiff_date_of_incident"
                    class="form-label form-field__title">DOI (Date of Incident)*</label>
                <div class="form-field__input-wrap">
                    <input class="form-field__input js-field-input form-control"
                        id="medical_chronology_request_plaintiff_date_of_incident" validateOnBlur="true" type="date"
                        name="medical_chronology_request_plaintiff_date_of_incident" value="" placeholder="" />
                </div>
                <span class="form-field__error js-field-error">Required field</span>
            </div>



            <div class="form-field col-6  is-required js-field js__textinput " data-type="">
                <label for="medical_chronology_request_plaintiff_location_of_accident"
                    class="form-label form-field__title">LOA (Location of Accident)*</label>
                <div class="form-field__input-wrap">
                    <input class="form-field__input js-field-input form-control"
                        id="medical_chronology_request_plaintiff_location_of_accident" validateOnBlur="true" type=""
                        name="medical_chronology_request_plaintiff_location_of_accident" value="" placeholder="" />
                </div>
                <span class="form-field__error js-field-error">Required field</span>
            </div>



            <div class="form-field col-6  is-required js-field js__textinput " data-type="">
                <label for="medical_chronology_request_plaintiff_first_name"
                    class="form-label form-field__title">Plaintiff First name*</label>
                <div class="form-field__input-wrap">
                    <input class="form-field__input js-field-input form-control"
                        id="medical_chronology_request_plaintiff_first_name" validateOnBlur="true" type=""
                        name="medical_chronology_request_plaintiff_first_name" value="" placeholder="" />
                </div>
                <span class="form-field__error js-field-error">Required field</span>
            </div>



            <div class="form-field col-6  is-required js-field js__textinput " data-type="">
                <label for="medical_chronology_request_plaintiff_last_name"
                    class="form-label form-field__title">Plaintiff Last name*</label>
                <div class="form-field__input-wrap">
                    <input class="form-field__input js-field-input form-control"
                        id="medical_chronology_request_plaintiff_last_name" validateOnBlur="true" type=""
                        name="medical_chronology_request_plaintiff_last_name" value="" placeholder="" />
                </div>
                <span class="form-field__error js-field-error">Required field</span>
            </div>



            <div class="form-field col-6  is-required js-field js__textinput " data-type="">
                <label for="medical_chronology_request_plaintiff_date_of_birth"
                    class="form-label form-field__title">Plaintiff DOB (Date of Birth)*</label>
                <div class="form-field__input-wrap">
                    <input class="form-field__input js-field-input form-control"
                        id="medical_chronology_request_plaintiff_date_of_birth" validateOnBlur="true" type="date"
                        name="medical_chronology_request_plaintiff_date_of_birth" value="" placeholder="" />
                </div>
                <span class="form-field__error js-field-error">Required field</span>
            </div>



            <div class="form-field col-6">

                <div class="medical-chronology-request-form-with-inputs__dropdown-field medical-chronology-request-form-with-inputs__input-field  js-medical-chronology-request__dropdown"
                    data-name="medical_chronology_request_plaintiff_gender">
                    <p class="medical-chronology-request-form-with-inputs__dropdown-field_label">Plaintiff Gender*</p>
                    <div class="medical-chronology-request-form-with-inputs__dropdown-wrap">
                        <input type="text" value="" name="medical_chronology_request_plaintiff_gender"
                            id="medical_chronology_request_plaintiff_gender"
                            class="medical-chronology-request-form-with-inputs__dropdown-field_input js-medical-chronology-request-dropdown-input">
                        <button type="button"
                            class="medical-chronology-request-form-with-inputs__dropdown-field_trigger js-medical-chronology-request-dropdown-trigger">
                            <span class="value">Select</span>

                            <svg class="icon icon-arrow-select ">
                                <use href="/assets/themes/default/icon/icons/icons.svg#arrow-select" />
                            </svg>

                        </button>
                        <div
                            class="medical-chronology-request-form-with-inputs__dropdown-field__list-wrap js-medical-chronology-request-dropdown-list-wrap">
                            <ul class="medical-chronology-request-form-with-inputs__dropdown-field__list js-medical-chronology-request-dropdown-list"
                                data-type="button">
                                <li class="medical-chronology-request-form-with-inputs__dropdown-field__list-item">
                                    <button type="button"
                                        class="medical-chronology-request-form-with-inputs__dropdown-field__list-trigger"
                                        data-gender="male" data-item-id="male" data-value="Male">Male</button>
                                </li>
                                <li class="medical-chronology-request-form-with-inputs__dropdown-field__list-item">
                                    <button type="button"
                                        class="medical-chronology-request-form-with-inputs__dropdown-field__list-trigger"
                                        data-gender="female" data-item-id="female" data-value="Female">Female</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>





            <div class="form-field col-4  is-required js-field js__textinput " data-type="name">
                <label for="defendant_first_name" class="form-label form-field__title">Defendant First Name*</label>
                <div class="form-field__input-wrap">
                    <input class="form-field__input js-field-input form-control" id="defendant_first_name"
                        validateOnBlur="true" type="" name="defendant_first_name" value="" placeholder="" />
                </div>
                <span class="form-field__error js-field-error">Required field</span>
            </div>



            <div class="form-field col-4  is-required js-field js__textinput " data-type="">
                <label for="defendant_last_name" class="form-label form-field__title">Defendant Last Name*</label>
                <div class="form-field__input-wrap">
                    <input class="form-field__input js-field-input form-control" id="defendant_last_name"
                        validateOnBlur="true" type="" name="defendant_last_name" value="" placeholder="" />
                </div>
                <span class="form-field__error js-field-error">Required field</span>
            </div>



            <div class="form-field col-4   js-field js__textinput " data-type="name">
                <label for="defendant_company_name" class="form-label form-field__title">Defendant Company Name
                    (Optional)</label>
                <div class="form-field__input-wrap">
                    <input class="form-field__input js-field-input form-control" id="defendant_company_name"
                        validateOnBlur="" type="" name="defendant_company_name" value="" placeholder="" />
                </div>
            </div>





            <div class="medical-chronology-request-form-with-inputs__dropdown-field medical-chronology-request-form-with-inputs__input-field  js-medical-chronology-request__dropdown"
                data-name="medical_chronology_request_claim_type">
                <p class="medical-chronology-request-form-with-inputs__dropdown-field_label">Claim type*</p>
                <div class="medical-chronology-request-form-with-inputs__dropdown-wrap">
                    <input type="text" value="" name="medical_chronology_request_claim_type"
                        id="medical_chronology_request_claim_type"
                        class="medical-chronology-request-form-with-inputs__dropdown-field_input js-medical-chronology-request-dropdown-input">
                    <button type="button"
                        class="medical-chronology-request-form-with-inputs__dropdown-field_trigger js-medical-chronology-request-dropdown-trigger">
                        <span class="value">Select</span>

                        <svg class="icon icon-arrow-select ">
                            <use href="/assets/themes/default/icon/icons/icons.svg#arrow-select" />
                        </svg>

                    </button>
                    <div
                        class="medical-chronology-request-form-with-inputs__dropdown-field__list-wrap claim-list-wrap js-medical-chronology-request-dropdown-list-wrap">
                        <ul class="medical-chronology-request-form-with-inputs__dropdown-field__list js-medical-chronology-request-dropdown-list"
                            data-type="button">
                            <li
                                class="medical-chronology-request-form-with-inputs__dropdown-field__list-item claim-item">
                                <button type="button"
                                    class="medical-chronology-request-form-with-inputs__dropdown-field__list-trigger claim-trigger"
                                    data-item-id="bodily_injury" data-value="Bodily injury" data-target="body"
                                    data-target-id="medical_chronology_request_injury_areas">
                                    <span class="title">Bodily Injury</span>
                                    <span class="text">A summary of medical records detailing bodily injuries, including
                                        diagnoses, treatments, and medical observations. This summary is tailored to
                                        provide
                                        insights relevant to injury claims.</span>
                                </button>
                            </li>
                            <li
                                class="medical-chronology-request-form-with-inputs__dropdown-field__list-item claim-item">
                                <button type="button"
                                    class="medical-chronology-request-form-with-inputs__dropdown-field__list-trigger claim-trigger"
                                    data-item-id="disability_claim" data-value="Disability claim"
                                    data-target-id="medical_chronology_request_injury_areas">
                                    <span class="title">Disability Claim</span>
                                    <span class="text">A summary of medical records focusing on disability or long-term
                                        care
                                        conditions, including medical assessments, treatments, and ongoing care
                                        needs.</span>
                                </button>
                            </li>
                            <li
                                class="medical-chronology-request-form-with-inputs__dropdown-field__list-item claim-item">
                                <button type="button"
                                    class="medical-chronology-request-form-with-inputs__dropdown-field__list-trigger claim-trigger"
                                    data-item-id="nursing_home_negligence" data-value="Nursing Home Negligence"
                                    data-target-id="medical_chronology_request_injury_areas">
                                    <span class="title">Nursing Home Negligence</span>
                                    <span class="text">A summary of medical records detailing instances of negligence in nursing homes, including inadequate medical care, failure to prevent falls,
                                            improper medication administration, neglect of basic hygiene, and instances of physical or emotional abuse. </span>
                                </button>
                            </li>
                            <li
                                class="medical-chronology-request-form-with-inputs__dropdown-field__list-item claim-item">
                                <button type="button"
                                    class="medical-chronology-request-form-with-inputs__dropdown-field__list-trigger claim-trigger"
                                    data-item-id="workers_compensation" data-value="Workers’ compensation"
                                    data-target-id="medical_chronology_request_injury_areas">
                                    <span class="title">Workers’ Compensation</span>
                                    <span class="text">A summary of medical records related to workers’ compensation,
                                        including
                                        the nature of the injury, treatments received, and current medical
                                        status.</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="medical-chronology-request-form-with-inputs__dropdown-field-wrap js-medical-chronology-request-hidden-dropdown"
                data-name="medical_chronology_request_injury_areas">
                <div class="medical-chronology-request-form-with-inputs__dropdown-field medical-chronology-request-form-with-inputs__input-field  js-medical-chronology-request__dropdown"
                    data-name="medical_chronology_request_injury_areas">
                    <p class="medical-chronology-request-form-with-inputs__dropdown-field_label">Injury areas* (Select
                        injury areas from the dropdown or the below diagrams)</p>
                    <div class="medical-chronology-request-form-with-inputs__dropdown-wrap">

                        <button type="button"
                            class="medical-chronology-request-form-with-inputs__dropdown-field_trigger js-medical-chronology-request-dropdown-trigger">
                            <span class="value">Select</span>

                            <svg class="icon icon-arrow-select ">
                                <use href="/assets/themes/default/icon/icons/icons.svg#arrow-select" />
                            </svg>

                        </button>
                        <div
                            class="medical-chronology-request-form-with-inputs__dropdown-field__list-wrap injury-list-wrap js-medical-chronology-request-dropdown-list-wrap">
                            <ul class="medical-chronology-request-form-with-inputs__dropdown-field__list js-medical-chronology-request-dropdown-list"
                                data-type="check">
                                <li
                                    class="medical-chronology-request-form-with-inputs__dropdown-field__list-item injury-item">
                                    <label class="injury-item-label">
                                        <input type="checkbox" name="injury_areas[]" id="injury_head_and_neck"
                                            value="head_and_neck" class="injury-item-checkbox js-injury-item-checkbox"
                                            data-target="selected_injury_head_and_neck" data-icon-class="head-and-neck">
                                        <span class="rectangle">

                                            <svg class="icon icon-check ">
                                                <use href="/assets/themes/default/icon/icons/icons.svg#check" />
                                            </svg>

                                        </span>
                                        <span class="injury-item-title ">
                                            <span class="injury-item-title-text"> HEAD AND NECK</span>
                                        </span>
                                        <span class="injury-item-description">
                                            <span class="injury-item-description_item">
                                                <b class="blue">Components:
                                                </b>
                                                Skull, Face, Brain, Eyes, Nose, Mouth, Ears, Cheeks, Jaw, Cervical
                                                spine.
                                            </span>
                                            <span class="injury-item-description_item">
                                                <b class="blue">Musculoskeletal:
                                                </b>
                                                Bones (Skull, Cervical spine), Muscles, and Connective Tissues (Neck
                                                muscles, tendons,
                                                ligaments).
                                            </span>
                                        </span>
                                    </label>
                                </li>
                                <li
                                    class="medical-chronology-request-form-with-inputs__dropdown-field__list-item injury-item">
                                    <label class="injury-item-label">
                                        <input type="checkbox" name="injury_areas[]" id="injury_upper_extremity"
                                            value="upper_extremity" class="injury-item-checkbox js-injury-item-checkbox"
                                            data-target="selected_injury_upper_extremity"
                                            data-icon-class="upper-extremity">
                                        <span class="rectangle">

                                            <svg class="icon icon-check ">
                                                <use href="/assets/themes/default/icon/icons/icons.svg#check" />
                                            </svg>

                                        </span>
                                        <span class="injury-item-title m-w-139">
                                            <span class="injury-item-title-text"> UPPER EXTREMITY (Right, Left, or
                                                Both)</span>
                                        </span>
                                        <span class="injury-item-description">
                                            <span class="injury-item-description_item">
                                                <b class="blue">Components:
                                                </b>
                                                Shoulder, Arm (Humerus, Radius, Ulna), Elbow, Forearm, Wrist, Hand
                                                (Carpals,
                                                Metacarpals, Phalanges, Fingers).
                                            </span>
                                            <span class="injury-item-description_item">
                                                <b class="blue">Musculoskeletal:
                                                </b>
                                                Bones (Clavicle, Scapula, Humerus, Radius, Ulna, Carpals, Metacarpals,
                                                Phalanges),
                                                Muscles, and Connective Tissues (Muscles, tendons, and ligaments of the
                                                upper limb).
                                            </span>
                                        </span>
                                    </label>
                                </li>
                                <li
                                    class="medical-chronology-request-form-with-inputs__dropdown-field__list-item injury-item">
                                    <label class="injury-item-label">
                                        <input type="checkbox" name="injury_areas[]" id="injury_torso" value="torso"
                                            class="injury-item-checkbox js-injury-item-checkbox"
                                            data-target="selected_injury_torso" data-icon-class="torso-full">
                                        <span class="rectangle">

                                            <svg class="icon icon-check ">
                                                <use href="/assets/themes/default/icon/icons/icons.svg#check" />
                                            </svg>

                                        </span>
                                        <span class="injury-item-title ">
                                            <span class="injury-item-title-text"> TORSO</span>
                                        </span>
                                        <span class="injury-item-description">
                                            <span class="injury-item-description_item">
                                                <b class="blue">Components:
                                                </b>
                                                Thorax (Chest, Ribcage, Sternum), Abdomen (Stomach, Liver, Spleen,
                                                Pancreas, Kidneys,
                                                Intestines), Pelvis (Hips, Reproductive Organs), Diaphragm.
                                            </span>
                                            <span class="injury-item-description_item">
                                                <b class="blue">Musculoskeletal:
                                                </b>
                                                Bones (Ribcage, Sternum, Pelvis), Muscles, and Connective Tissues
                                                (Abdominal muscles,
                                                pelvic muscles, diaphragm).
                                            </span>
                                        </span>
                                    </label>
                                </li>
                                <li
                                    class="medical-chronology-request-form-with-inputs__dropdown-field__list-item injury-item">
                                    <label class="injury-item-label">
                                        <input type="checkbox" name="injury_areas[]" id="injury_back" value="back"
                                            class="injury-item-checkbox js-injury-item-checkbox"
                                            data-target="selected_injury_back" data-icon-class="back">
                                        <span class="rectangle">

                                            <svg class="icon icon-check ">
                                                <use href="/assets/themes/default/icon/icons/icons.svg#check" />
                                            </svg>

                                        </span>
                                        <span class="injury-item-title ">
                                            <span class="injury-item-title-text"> BACK</span>
                                        </span>
                                        <span class="injury-item-description">
                                            <span class="injury-item-description_item">
                                                <b class="blue">Components:
                                                </b>
                                                Thoracic Spine, Lumbar Spine, Coccyx, Sacrum, Clavicle, Scapula.
                                            </span>
                                            <span class="injury-item-description_item">
                                                <b class="blue">Musculoskeletal:
                                                </b>
                                                Bones (Thoracic Spine, Lumbar Spine, Coccyx, Sacrum, Clavicle, Scapula),
                                                Muscles, and
                                                Connective Tissues (Muscles and ligaments supporting the back and spinal
                                                column).
                                            </span>
                                        </span>
                                    </label>
                                </li>
                                <li
                                    class="medical-chronology-request-form-with-inputs__dropdown-field__list-item injury-item">
                                    <label class="injury-item-label">
                                        <input type="checkbox" name="injury_areas[]" id="injury_lower_extremity"
                                            value="lower_extremity" class="injury-item-checkbox js-injury-item-checkbox"
                                            data-target="selected_injury_lower_extremity"
                                            data-icon-class="lower-extremity">
                                        <span class="rectangle">

                                            <svg class="icon icon-check ">
                                                <use href="/assets/themes/default/icon/icons/icons.svg#check" />
                                            </svg>

                                        </span>
                                        <span class="injury-item-title m-w-139">
                                            <span class="injury-item-title-text"> LOWER EXTREMITY (Right, Left, or
                                                Both)</span>
                                        </span>
                                        <span class="injury-item-description">
                                            <span class="injury-item-description_item">
                                                <b class="blue">Components:
                                                </b>
                                                Hip, Thigh (Femur), Knee (Patella), Leg (Tibia, Fibula), Ankle, Foot
                                                (Tarsals,
                                                Metatarsals, Phalanges, Toes).
                                            </span>
                                            <span class="injury-item-description_item">
                                                <b class="blue">Musculoskeletal:
                                                </b>
                                                Bones (Femur, Patella, Tibia, Fibula, Tarsals, Metatarsals, Phalanges),
                                                Muscles, and
                                                Connective Tissues (Muscles, tendons, and ligaments of the lower limb).
                                            </span>
                                        </span>
                                    </label>
                                </li>
                                <li
                                    class="medical-chronology-request-form-with-inputs__dropdown-field__list-item injury-item">
                                    <label class="injury-item-label">
                                        <input type="checkbox" name="injury_areas[]" id="injury_internal_organs"
                                            value="internal_organs" class="injury-item-checkbox js-injury-item-checkbox"
                                            data-target="selected_injury_internal_organs"
                                            data-icon-class="internal-organs">
                                        <span class="rectangle">

                                            <svg class="icon icon-check ">
                                                <use href="/assets/themes/default/icon/icons/icons.svg#check" />
                                            </svg>

                                        </span>
                                        <span class="injury-item-title ">
                                            <span class="injury-item-title-text"> INTERNAL ORGANS</span>
                                        </span>
                                        <span class="injury-item-description">
                                            <span class="injury-item-description_item">
                                                <b class="blue">Components:
                                                </b>
                                                Heart, Lungs, Liver, Spleen, Pancreas, Kidneys, Bladder, Stomach,
                                                Intestines,
                                                Reproductive Organs.
                                            </span>
                                        </span>
                                    </label>
                                </li>
                                <li
                                    class="medical-chronology-request-form-with-inputs__dropdown-field__list-item injury-item">
                                    <label class="injury-item-label">
                                        <input type="checkbox" name="injury_areas[]" id="injury_skin" value="skin"
                                            class="injury-item-checkbox js-injury-item-checkbox"
                                            data-target="selected_injury_skin" data-icon-class="skin">
                                        <span class="rectangle">

                                            <svg class="icon icon-check ">
                                                <use href="/assets/themes/default/icon/icons/icons.svg#check" />
                                            </svg>

                                        </span>
                                        <span class="injury-item-title ">
                                            <span class="injury-item-title-text"> SKIN</span>
                                        </span>
                                        <span class="injury-item-description">
                                            <span class="injury-item-description_item">
                                                <b class="blue">Components:
                                                </b>
                                                The body's largest organ, covering and protecting all external surfaces.
                                            </span>
                                        </span>
                                    </label>
                                </li>
                                <li
                                    class="medical-chronology-request-form-with-inputs__dropdown-field__list-item injury-item">
                                    <label class="injury-item-label">
                                        <input type="checkbox" name="injury_areas[]"
                                            id="injury_circulatory_and_nervous_systems"
                                            value="circulatory_and_nervous_systems"
                                            class="injury-item-checkbox js-injury-item-checkbox"
                                            data-target="selected_injury_circulatory_and_nervous_systems"
                                            data-icon-class="nerv-system">
                                        <span class="rectangle">

                                            <svg class="icon icon-check ">
                                                <use href="/assets/themes/default/icon/icons/icons.svg#check" />
                                            </svg>

                                        </span>
                                        <span class="injury-item-title ">
                                            <span class="injury-item-title-text"> CIRCULATORY AND NERVOUS SYSTEMS</span>
                                        </span>
                                        <span class="injury-item-description">
                                            <span class="injury-item-description_item">
                                                <b class="blue">Components:
                                                </b>
                                                Includes Blood Vessels and Nerves throughout the body.
                                            </span>
                                        </span>
                                    </label>
                                </li>
                                <li
                                    class="medical-chronology-request-form-with-inputs__dropdown-field__list-item injury-footer">
                                    <button type="button" class="btn btn-primary injury-footer-btn js-injury-add-btn"
                                        aria-label="Add injury areas">Add</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


        </form>

        <div
            class="medical-chronology-request-form__selected-injuries-list-wrap js-medical-chronology-request-selected-injuries-list-wrap">
            <ul
                class="medical-chronology-request-form__selected-injuries-list js-medical-chronology-request-selected-injuries-list">
                <li class="medical-chronology-request-form__selected-injuries-list-item selected-injury-item">
                    <label class="injury-item-label">
                        <input type="checkbox" name="injury_areas[]" id="selected_injury_head_and_neck"
                            value="" class="injury-item-checkbox js-selected-injury-item-checkbox"
                            data-item-id="injury_head_and_neck" data-icon-class="head-and-neck">
                        <span class="rectangle">

                            <svg class="icon icon-check ">
                                <use href="/assets/themes/default/icon/icons/icons.svg#check" />
                            </svg>

                        </span>
                        <span class="injury-item-title">
                            <span class="injury-item-title-text">HEAD AND NECK</span>
                        </span>
                        <span class="injury-item-description">
                            <span class="injury-item-description_item">
                                <b class="blue">Components:
                                </b>
                                Skull, Face, Brain, Eyes, Nose, Mouth, Ears, Cheeks, Jaw, Cervical spine.
                            </span>
                            <span class="injury-item-description_item">
                                <b class="blue">Musculoskeletal:
                                </b>
                                Bones (Skull, Cervical spine), Muscles, and Connective Tissues (Neck muscles, tendons,
                                ligaments).
                            </span>
                        </span>
                    </label>
                </li>
                <li class="medical-chronology-request-form__selected-injuries-list-item selected-injury-item">
                    <label class="injury-item-label">
                        <input type="checkbox" name="injury_areas[]"
                            id="selected_injury_upper_extremity" value=""
                            class="injury-item-checkbox js-selected-injury-item-checkbox"
                            data-item-id="injury_upper_extremity" data-icon-class="upper-extremity">
                        <span class="rectangle">

                            <svg class="icon icon-check ">
                                <use href="/assets/themes/default/icon/icons/icons.svg#check" />
                            </svg>

                        </span>
                        <span class="injury-item-title">
                            <span class="injury-item-title-text">UPPER EXTREMITY (Right, Left, or Both)</span>
                        </span>
                        <span class="injury-item-description">
                            <span class="injury-item-description_item">
                                <b class="blue">Components:
                                </b>
                                Shoulder, Arm (Humerus, Radius, Ulna), Elbow, Forearm, Wrist, Hand (Carpals,
                                Metacarpals,
                                Phalanges, Fingers).
                            </span>
                            <span class="injury-item-description_item">
                                <b class="blue">Musculoskeletal:
                                </b>
                                Bones (Clavicle, Scapula, Humerus, Radius, Ulna, Carpals, Metacarpals, Phalanges),
                                Muscles, and
                                Connective Tissues (Muscles, tendons, and ligaments of the upper limb).
                            </span>
                        </span>
                    </label>
                </li>
                <li class="medical-chronology-request-form__selected-injuries-list-item selected-injury-item">
                    <label class="injury-item-label">
                        <input type="checkbox" name="injury_areas[]" id="selected_injury_torso" value=""
                            class="injury-item-checkbox js-selected-injury-item-checkbox" data-item-id="injury_torso"
                            data-icon-class="torso-full">
                        <span class="rectangle">

                            <svg class="icon icon-check ">
                                <use href="/assets/themes/default/icon/icons/icons.svg#check" />
                            </svg>

                        </span>
                        <span class="injury-item-title">
                            <span class="injury-item-title-text">TORSO</span>
                        </span>
                        <span class="injury-item-description">
                            <span class="injury-item-description_item">
                                <b class="blue">Components:
                                </b>
                                Thorax (Chest, Ribcage, Sternum), Abdomen (Stomach, Liver, Spleen, Pancreas, Kidneys,
                                Intestines), Pelvis (Hips, Reproductive Organs), Diaphragm.
                            </span>
                            <span class="injury-item-description_item">
                                <b class="blue">Musculoskeletal:
                                </b>
                                Bones (Ribcage, Sternum, Pelvis), Muscles, and Connective Tissues (Abdominal muscles,
                                pelvic
                                muscles, diaphragm).
                            </span>
                        </span>
                    </label>
                </li>
                <li class="medical-chronology-request-form__selected-injuries-list-item selected-injury-item">
                    <label class="injury-item-label">
                        <input type="checkbox" name="injury_areas[]" id="selected_injury_back" value=""
                            class="injury-item-checkbox js-selected-injury-item-checkbox" data-item-id="injury_back"
                            data-icon-class="back">
                        <span class="rectangle">

                            <svg class="icon icon-check ">
                                <use href="/assets/themes/default/icon/icons/icons.svg#check" />
                            </svg>

                        </span>
                        <span class="injury-item-title">
                            <span class="injury-item-title-text">BACK</span>
                        </span>
                        <span class="injury-item-description">
                            <span class="injury-item-description_item">
                                <b class="blue">Components:
                                </b>
                                Thoracic Spine, Lumbar Spine, Coccyx, Sacrum, Clavicle, Scapula.
                            </span>
                            <span class="injury-item-description_item">
                                <b class="blue">Musculoskeletal:
                                </b>
                                Bones (Thoracic Spine, Lumbar Spine, Coccyx, Sacrum, Clavicle, Scapula), Muscles, and
                                Connective
                                Tissues (Muscles and ligaments supporting the back and spinal column).
                            </span>
                        </span>
                    </label>
                </li>
                <li class="medical-chronology-request-form__selected-injuries-list-item selected-injury-item">
                    <label class="injury-item-label">
                        <input type="checkbox" name="injury_areas[]"
                            id="selected_injury_lower_extremity" value=""
                            class="injury-item-checkbox js-selected-injury-item-checkbox"
                            data-item-id="injury_lower_extremity" data-icon-class="lower-extremity">
                        <span class="rectangle">

                            <svg class="icon icon-check ">
                                <use href="/assets/themes/default/icon/icons/icons.svg#check" />
                            </svg>

                        </span>
                        <span class="injury-item-title">
                            <span class="injury-item-title-text">LOWER EXTREMITY (Right, Left, or Both)</span>
                        </span>
                        <span class="injury-item-description">
                            <span class="injury-item-description_item">
                                <b class="blue">Components:
                                </b>
                                Hip, Thigh (Femur), Knee (Patella), Leg (Tibia, Fibula), Ankle, Foot (Tarsals,
                                Metatarsals,
                                Phalanges, Toes).
                            </span>
                            <span class="injury-item-description_item">
                                <b class="blue">Musculoskeletal:
                                </b>
                                Bones (Femur, Patella, Tibia, Fibula, Tarsals, Metatarsals, Phalanges), Muscles, and
                                Connective
                                Tissues (Muscles, tendons, and ligaments of the lower limb).
                            </span>
                        </span>
                    </label>
                </li>
                <li class="medical-chronology-request-form__selected-injuries-list-item selected-injury-item">
                    <label class="injury-item-label">
                        <input type="checkbox" name="injury_areas[]"
                            id="selected_injury_internal_organs" value=""
                            class="injury-item-checkbox js-selected-injury-item-checkbox"
                            data-item-id="injury_internal_organs" data-icon-class="internal-organs">
                        <span class="rectangle">

                            <svg class="icon icon-check ">
                                <use href="/assets/themes/default/icon/icons/icons.svg#check" />
                            </svg>

                        </span>
                        <span class="injury-item-title">
                            <span class="injury-item-title-text">INTERNAL ORGANS: Heart, Lungs, Liver, Spleen, Pancreas,
                                Kidneys, Bladder, Stomach, Intestines, Reproductive Organs.</span>
                        </span>
                    </label>
                </li>
                <li class="medical-chronology-request-form__selected-injuries-list-item selected-injury-item">
                    <label class="injury-item-label">
                        <input type="checkbox" name="injury_areas[]" id="selected_injury_skin" value=""
                            class="injury-item-checkbox js-selected-injury-item-checkbox" data-item-id="injury_skin"
                            data-icon-class="skin">
                        <span class="rectangle">

                            <svg class="icon icon-check ">
                                <use href="/assets/themes/default/icon/icons/icons.svg#check" />
                            </svg>

                        </span>
                        <span class="injury-item-title">
                            <span class="injury-item-title-text">SKIN: The body's largest organ, covering and protecting
                                all
                                external surfaces.</span>
                        </span>
                    </label>
                </li>
                <li class="medical-chronology-request-form__selected-injuries-list-item selected-injury-item">
                    <label class="injury-item-label">
                        <input type="checkbox" name="injury_areas[]"
                            id="selected_injury_circulatory_and_nervous_systems" value=""
                            class="injury-item-checkbox js-selected-injury-item-checkbox"
                            data-item-id="injury_circulatory_and_nervous_systems" data-icon-class="nerv-system">
                        <span class="rectangle">

                            <svg class="icon icon-check ">
                                <use href="/assets/themes/default/icon/icons/icons.svg#check" />
                            </svg>

                        </span>
                        <span class="injury-item-title">
                            <span class="injury-item-title-text">CIRCULATORY AND NERVOUS SYSTEMS: Includes Blood Vessels
                                and
                                Nerves throughout the body.</span>
                        </span>
                    </label>
                </li>
            </ul>
        </div>
        <div class="human-body-areas-wrap js-human-body-areas-wrap">
            <div class="human-body-areas">
                <div class="human-body-areas_area human-body-areas-front">
                    <h3 class="human-body-areas_area-title">Front</h3>
                    <svg width="161" height="510" viewbox="0 0 161 510" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="human-body-areas_female js-human-body-svg">
                        <g class="nerv-system js-body-area" data-body-part="nerv-system">
                            <path
                                d="M153.63 257.844C153.061 255.998 153.577 255.429 153.234 253.943C152.985 252.865 152.904 252.332 152.141 250.807C151.963 250.451 151.504 245.191 151.298 241.504C150.429 233.098 149.306 192.55 147.939 185.168C146.441 177.08 143.663 170.98 142.583 165.587C141.503 160.194 142.253 154.604 141.772 143.22C141.595 139.009 140.456 130.039 141.055 122.248C141.654 114.457 140.806 97.8708 134.763 89.5915C131.469 85.0805 123.346 83.4882 115.337 81.3638C107.33 79.2393 98.1546 76.3565 95.545 71.9766C94.9223 70.9323 93.278 65.9925 93.278 62.2281L66.7683 61.9382C66.5178 65.4445 65.0474 70.6861 64.306 71.9329C61.6971 76.3088 52.6923 79.2393 44.6842 81.3638C36.6762 83.4882 28.5521 85.0805 25.2579 89.5915C19.2162 97.8708 18.3672 114.457 18.9668 122.248C19.5656 130.039 18.4268 139.009 18.2493 143.22C17.7684 154.604 18.5185 160.194 17.4384 165.587C16.3579 170.98 13.5803 177.08 12.0829 185.168C10.7169 192.543 9.5947 233.025 8.72626 241.481C8.52256 245.112 8.05002 250.353 7.87411 250.706C7.10972 252.235 7.01918 252.77 6.76981 253.851C6.42553 255.341 6.95168 255.909 6.38226 257.76C6.14679 258.523 5.63018 261.368 4.63825 264.237C3.2262 268.319 1.25901 272.719 1.25782 273.559C1.25464 276.208 3.04473 285.498 4.79867 287.779C6.40609 289.868 13.3551 294.128 14.494 294.128C15.6324 294.128 16.2019 292.988 16.2019 292.988C16.2019 292.988 18.1615 293.663 18.4796 292.276C18.9064 290.414 16.6267 289.277 15.7726 288.565C14.9189 287.854 12.7667 286.682 11.6286 284.404C10.4897 282.127 10.7852 273.371 12.0757 273.132C14.1191 272.754 14.1573 275.718 14.0195 278.199C13.9238 279.91 13.7435 283.711 15.8302 283.916C19.6784 284.294 18.6233 276.691 18.6233 274.413C18.6233 272.136 19.9762 269.282 20.189 267.296C20.6159 263.311 17.3423 259.04 17.3423 255.625C17.3423 254.7 18.3557 250.606 19.8316 245.001C23.1612 231.065 35.8482 188.891 35.8482 182.156C35.8482 177.135 36.8743 168.934 37.3548 163.746C37.651 160.541 39.2965 147.699 40.6042 137.032C41.9054 139.795 42.8807 140.609 43.6943 141.749C43.9822 147.97 45.0921 161.449 45.4391 165.266C45.9502 170.885 47.9924 175.741 46.9445 183.379C46.2154 188.689 42.6666 193.415 40.9222 197.121C37.163 205.11 34.4024 216.069 33.3732 222.381C31.4485 234.182 30.9128 239.411 30.2314 243.498C29.5504 247.585 25.923 262.936 26.0934 272.813C26.2637 282.689 39.2052 343.141 39.3756 345.527C39.5459 347.91 38.8649 352.845 39.0353 355.911C39.2052 358.976 40.3973 364.595 40.3973 367.494C40.3973 370.389 36.1869 384.513 36.1401 391.843C35.9697 418.579 43.3111 463.959 43.4815 467.874C43.6518 471.789 42.5967 474.152 42.3887 475.609C42.1806 477.067 41.3634 479.866 41.6755 481.633C38.9685 486.839 31.265 494.753 29.1831 495.793C27.1011 496.834 25.8579 498.247 25.3095 499.443C25.0728 499.959 25.3123 500.658 25.7205 500.944C25.1757 502.508 26.3693 503.243 27.1333 503.108C27.1147 503.815 27.5908 504.311 27.964 504.506C29.3991 505.256 30.3517 504.017 30.3517 504.017C30.3517 504.017 30.2187 505.196 31.7983 506.01C33.2445 506.761 35.2208 505.161 35.2208 505.161C35.2208 505.161 34.3091 506.944 36.3418 508.024C37.8619 508.83 40.4056 508.536 42.405 507.658C45.6047 506.253 47.9539 503.231 48.2342 502.977C48.7286 502.52 50.6644 502.083 52.0026 500.9C54.1505 499.002 53.882 497.826 54.5845 497.04C55.0137 496.564 58.3802 496.496 60.8168 494.046C62.6021 492.251 61.8937 488.34 61.5117 486.871C60.8676 484.397 60.2056 481.53 60.2056 480.696C60.2056 479.866 60.1544 477.198 60.0504 475.534C59.9464 473.866 58.1074 470.511 57.9597 466.028C57.8299 462.096 67.6284 408.871 67.3548 401.211C67.0812 393.547 65.2082 389.457 65.3781 384.35C65.5485 379.244 70.3167 367.661 71.1681 356.935C72.0198 346.206 69.1247 343.482 69.4654 338.201C69.8061 332.923 76.2766 282.349 76.6177 276.389C76.8774 271.831 76.5339 269.314 76.5856 266.86C77.4965 267.078 78.9367 267.312 79.8552 267.289C81.3204 267.252 82.1789 266.984 83.4699 266.746C83.6454 269.355 83.1105 271.246 83.4044 276.389C83.7447 282.349 90.2152 332.923 90.5559 338.201C90.8966 343.482 88.0015 346.206 88.8532 356.935C89.7046 367.661 94.4728 379.244 94.6432 384.35C94.8131 389.457 92.9401 393.547 92.6665 401.211C92.3933 408.871 102.192 462.096 102.062 466.028C101.914 470.511 100.075 473.866 99.9713 475.534C99.8669 477.198 99.8157 479.866 99.8157 480.696C99.8157 481.53 99.1537 484.397 98.5096 486.871C98.1284 488.34 97.4192 492.251 99.2045 494.046C101.641 496.496 105.008 496.564 105.438 497.04C106.139 497.826 105.871 499.002 108.019 500.9C109.357 502.083 111.293 502.52 111.788 502.977C112.068 503.231 114.417 506.253 117.616 507.658C119.616 508.536 122.16 508.83 123.679 508.024C125.713 506.944 124.8 505.161 124.8 505.161C124.8 505.161 126.777 506.761 128.223 506.01C129.804 505.196 129.67 504.017 129.67 504.017C129.67 504.017 130.623 505.256 132.057 504.506C132.431 504.311 132.907 503.815 132.888 503.108C133.652 503.243 134.846 502.508 134.302 500.944C134.709 500.658 134.95 499.959 134.712 499.443C134.163 498.247 132.92 496.834 130.839 495.793C128.757 494.753 121.053 486.839 118.346 481.633C118.658 479.866 117.841 477.067 117.633 475.609C117.425 474.152 116.37 471.789 116.54 467.874C116.71 463.959 124.052 418.579 123.882 391.843C123.834 384.513 119.624 370.389 119.624 367.494C119.624 364.595 120.816 358.976 120.986 355.911C121.156 352.845 120.475 347.91 120.646 345.527C120.816 343.141 133.758 282.689 133.928 272.813C134.098 262.936 130.471 247.585 129.79 243.498C129.109 239.411 128.573 234.182 126.649 222.381C125.619 216.069 122.859 205.11 119.099 197.121C117.355 193.415 113.806 188.689 113.077 183.379C112.029 175.741 114.071 170.885 114.583 165.266C114.93 161.449 115.868 147.646 116.156 141.425C117.521 140.32 118.948 138.624 119.316 136.686C120.623 147.352 122.37 160.541 122.667 163.746C123.147 168.934 124.173 177.135 124.173 182.156C124.173 188.874 136.266 230.282 139.632 244.326C139.623 244.327 139.615 244.329 139.632 244.326C140.843 248.977 142.695 254.894 142.695 255.714C142.695 259.122 139.428 263.383 139.854 267.359C140.067 269.341 141.416 272.188 141.416 274.46C141.416 276.731 140.308 283.891 144.164 283.769C146.035 283.711 145.755 279.765 145.897 278.061C146.039 276.357 145.91 272.804 147.949 273.181C149.236 273.419 149.531 282.155 148.395 284.427C147.259 286.7 145.115 287.868 144.262 288.578C143.41 289.288 141.136 290.422 141.562 292.28C141.88 293.663 143.835 292.988 143.835 292.988C143.835 292.988 144.402 294.128 145.539 294.128C146.674 294.128 153.606 289.879 155.21 287.795C156.959 285.519 158.745 276.251 158.742 273.607C158.741 272.769 156.778 268.379 155.369 264.307C154.379 261.445 153.863 258.606 153.63 257.844Z"
                                fill="#F6F9FE" />
                            <path
                                d="M153.63 257.844C153.061 255.998 153.577 255.429 153.234 253.943C152.985 252.865 152.904 252.332 152.141 250.807C151.963 250.451 151.504 245.191 151.298 241.504C150.429 233.098 149.306 192.55 147.939 185.168C146.441 177.08 143.663 170.98 142.583 165.587C141.503 160.194 142.253 154.604 141.772 143.22C141.595 139.009 140.456 130.039 141.055 122.248C141.654 114.457 140.806 97.8708 134.763 89.5915C131.469 85.0805 123.346 83.4882 115.337 81.3638C107.33 79.2393 98.1546 76.3565 95.545 71.9766C94.9223 70.9323 93.278 65.9925 93.278 62.2281L66.7683 61.9382C66.5178 65.4445 65.0474 70.6861 64.306 71.9329C61.6971 76.3088 52.6923 79.2393 44.6842 81.3638C36.6762 83.4882 28.5521 85.0805 25.2579 89.5915C19.2162 97.8708 18.3672 114.457 18.9668 122.248C19.5656 130.039 18.4268 139.009 18.2493 143.22C17.7684 154.604 18.5185 160.194 17.4384 165.587C16.3579 170.98 13.5803 177.08 12.0829 185.168C10.7169 192.543 9.5947 233.025 8.72626 241.481C8.52256 245.112 8.05002 250.353 7.87411 250.706C7.10972 252.235 7.01918 252.77 6.76981 253.851C6.42553 255.341 6.95168 255.909 6.38226 257.76C6.14679 258.523 5.63018 261.368 4.63825 264.237C3.2262 268.319 1.25901 272.719 1.25782 273.559C1.25464 276.208 3.04473 285.498 4.79867 287.779C6.40609 289.868 13.3551 294.128 14.494 294.128C15.6324 294.128 16.2019 292.988 16.2019 292.988C16.2019 292.988 18.1615 293.663 18.4796 292.276C18.9064 290.414 16.6267 289.277 15.7726 288.565C14.9189 287.854 12.7667 286.682 11.6286 284.404C10.4897 282.127 10.7852 273.371 12.0757 273.132C14.1191 272.754 14.1573 275.718 14.0195 278.199C13.9238 279.91 13.7435 283.711 15.8302 283.916C19.6784 284.294 18.6233 276.691 18.6233 274.413C18.6233 272.136 19.9762 269.282 20.189 267.296C20.6159 263.311 17.3423 259.04 17.3423 255.625C17.3423 254.7 18.3557 250.606 19.8316 245.001C23.1612 231.065 35.8482 188.891 35.8482 182.156C35.8482 177.135 36.8743 168.934 37.3548 163.746C37.651 160.541 39.2965 147.699 40.6042 137.032C41.9054 139.795 42.8807 140.609 43.6943 141.749C43.9822 147.97 45.0921 161.449 45.4391 165.266C45.9502 170.885 47.9924 175.741 46.9445 183.379C46.2154 188.689 42.6666 193.415 40.9222 197.121C37.163 205.11 34.4024 216.069 33.3732 222.381C31.4485 234.182 30.9128 239.411 30.2314 243.498C29.5504 247.585 25.923 262.936 26.0934 272.813C26.2637 282.689 39.2052 343.141 39.3756 345.527C39.5459 347.91 38.8649 352.845 39.0353 355.911C39.2052 358.976 40.3973 364.595 40.3973 367.494C40.3973 370.389 36.1869 384.513 36.1401 391.843C35.9697 418.579 43.3111 463.959 43.4815 467.874C43.6518 471.789 42.5967 474.152 42.3887 475.609C42.1806 477.067 41.3634 479.866 41.6755 481.633C38.9685 486.839 31.265 494.753 29.1831 495.793C27.1011 496.834 25.8579 498.247 25.3095 499.443C25.0728 499.959 25.3123 500.658 25.7205 500.944C25.1757 502.508 26.3693 503.243 27.1333 503.108C27.1147 503.815 27.5908 504.311 27.964 504.506C29.3991 505.256 30.3517 504.017 30.3517 504.017C30.3517 504.017 30.2187 505.196 31.7983 506.01C33.2445 506.761 35.2208 505.161 35.2208 505.161C35.2208 505.161 34.3091 506.944 36.3418 508.024C37.8619 508.83 40.4056 508.536 42.405 507.658C45.6047 506.253 47.9539 503.231 48.2342 502.977C48.7286 502.52 50.6644 502.083 52.0026 500.9C54.1505 499.002 53.882 497.826 54.5845 497.04C55.0137 496.564 58.3802 496.496 60.8168 494.046C62.6021 492.251 61.8937 488.34 61.5117 486.871C60.8676 484.397 60.2056 481.53 60.2056 480.696C60.2056 479.866 60.1544 477.198 60.0504 475.534C59.9464 473.866 58.1074 470.511 57.9597 466.028C57.8299 462.096 67.6284 408.871 67.3548 401.211C67.0812 393.547 65.2082 389.457 65.3781 384.35C65.5485 379.244 70.3167 367.661 71.1681 356.935C72.0198 346.206 69.1247 343.482 69.4654 338.201C69.8061 332.923 76.2766 282.349 76.6177 276.389C76.8774 271.831 76.5339 269.314 76.5856 266.86C77.4965 267.078 78.9367 267.312 79.8552 267.289C81.3204 267.252 82.1789 266.984 83.4699 266.746C83.6454 269.355 83.1105 271.246 83.4044 276.389C83.7447 282.349 90.2152 332.923 90.5559 338.201C90.8966 343.482 88.0015 346.206 88.8532 356.935C89.7046 367.661 94.4728 379.244 94.6432 384.35C94.8131 389.457 92.9401 393.547 92.6665 401.211C92.3933 408.871 102.192 462.096 102.062 466.028C101.914 470.511 100.075 473.866 99.9713 475.534C99.8669 477.198 99.8157 479.866 99.8157 480.696C99.8157 481.53 99.1537 484.397 98.5096 486.871C98.1284 488.34 97.4192 492.251 99.2045 494.046C101.641 496.496 105.008 496.564 105.438 497.04C106.139 497.826 105.871 499.002 108.019 500.9C109.357 502.083 111.293 502.52 111.788 502.977C112.068 503.231 114.417 506.253 117.616 507.658C119.616 508.536 122.16 508.83 123.679 508.024C125.713 506.944 124.8 505.161 124.8 505.161C124.8 505.161 126.777 506.761 128.223 506.01C129.804 505.196 129.67 504.017 129.67 504.017C129.67 504.017 130.623 505.256 132.057 504.506C132.431 504.311 132.907 503.815 132.888 503.108C133.652 503.243 134.846 502.508 134.302 500.944C134.709 500.658 134.95 499.959 134.712 499.443C134.163 498.247 132.92 496.834 130.839 495.793C128.757 494.753 121.053 486.839 118.346 481.633C118.658 479.866 117.841 477.067 117.633 475.609C117.425 474.152 116.37 471.789 116.54 467.874C116.71 463.959 124.052 418.579 123.882 391.843C123.834 384.513 119.624 370.389 119.624 367.494C119.624 364.595 120.816 358.976 120.986 355.911C121.156 352.845 120.475 347.91 120.646 345.527C120.816 343.141 133.758 282.689 133.928 272.813C134.098 262.936 130.471 247.585 129.79 243.498C129.109 239.411 128.573 234.182 126.649 222.381C125.619 216.069 122.859 205.11 119.099 197.121C117.355 193.415 113.806 188.689 113.077 183.379C112.029 175.741 114.071 170.885 114.583 165.266C114.93 161.449 115.868 147.646 116.156 141.425C117.521 140.32 118.948 138.624 119.316 136.686C120.623 147.352 122.37 160.541 122.667 163.746C123.147 168.934 124.173 177.135 124.173 182.156C124.173 188.874 136.266 230.282 139.632 244.326C139.623 244.327 139.615 244.329 139.632 244.326C140.843 248.977 142.695 254.894 142.695 255.714C142.695 259.122 139.428 263.383 139.854 267.359C140.067 269.341 141.416 272.188 141.416 274.46C141.416 276.731 140.308 283.891 144.164 283.769C146.035 283.711 145.755 279.765 145.897 278.061C146.039 276.357 145.91 272.804 147.949 273.181C149.236 273.419 149.531 282.155 148.395 284.427C147.259 286.7 145.115 287.868 144.262 288.578C143.41 289.288 141.136 290.422 141.562 292.28C141.88 293.663 143.835 292.988 143.835 292.988C143.835 292.988 144.402 294.128 145.539 294.128C146.674 294.128 153.606 289.879 155.21 287.795C156.959 285.519 158.745 276.251 158.742 273.607C158.741 272.769 156.778 268.379 155.369 264.307C154.379 261.445 153.863 258.606 153.63 257.844Z"
                                stroke="#9AA0A9" stroke-width="2.38414" mask="url(#path-1-outside-1_5656_210981)" />
                        </g>
                        <g class="skin" data-body-part="skin">
                            <g class="head-and-neck js-body-area" data-body-part="head-and-neck">
                                <path
                                    d="M105.87 12.4915L105.87 12.4914C103.073 7.38799 97.4207 3.70916 91.0847 1.88543C84.7507 0.0622787 77.8503 0.128105 72.6417 2.38166L72.4825 2.45055L72.3112 2.42323C63.5471 1.02556 58.4187 6.33516 54.5144 10.6936C53.5961 11.7187 52.1712 14.0179 50.6328 17.1209C49.1031 20.2065 47.4856 24.0373 46.1705 28.0893C44.8547 32.1435 43.8475 36.4016 43.5275 40.346C43.2068 44.2998 43.5817 47.8783 44.969 50.6192L44.969 50.6192C49.6219 59.8142 59.4706 62.2085 63.0503 62.6722L63.0514 62.6724C63.3386 62.7101 63.6438 62.7507 63.9752 62.7947C64.3727 62.8474 64.8078 62.9052 65.2945 62.9691L94.002 63.5555C103.166 62.3644 112.289 59.3976 118.685 53.0181C114.295 52.0678 111.729 49.6144 110.349 46.5836C108.878 43.3502 108.781 39.5166 109.11 36.2819C109.43 33.139 109.372 28.5489 108.851 24.046C108.327 19.5268 107.347 15.1858 105.87 12.4915Z"
                                    fill="#9AA0A9" stroke="#9AA0A9" stroke-width="1.19207" />
                                <path
                                    d="M101.148 38.2654L101.148 38.2654L100.877 40.5839L102.503 38.9211L102.509 38.9153C102.519 38.9062 102.538 38.8904 102.563 38.8718C102.616 38.832 102.68 38.7937 102.742 38.771C102.802 38.7492 102.834 38.7507 102.849 38.7535C102.855 38.7546 102.907 38.7625 102.998 38.8586C103 38.8635 103.037 38.9245 103.057 39.103C103.081 39.3124 103.073 39.6011 103.026 39.9679C102.932 40.6992 102.698 41.6094 102.405 42.554C102.114 43.4917 101.774 44.4316 101.482 45.2155C101.39 45.4619 101.301 45.698 101.219 45.9151C101.047 46.3675 100.907 46.7376 100.839 46.9479C100.767 47.1727 100.728 47.4369 100.7 47.6809C100.672 47.9311 100.651 48.2166 100.629 48.5044L100.629 48.5152C100.584 49.1137 100.536 49.7534 100.424 50.3565C100.312 50.9684 100.147 51.4619 99.9177 51.7969C99.7117 52.0979 99.4639 52.2635 99.0894 52.2909L98.5334 52.3317L98.3811 52.868C97.5869 55.6655 95.9897 60.0552 93.3696 62.7203L93.3696 62.7204C90.7996 65.3351 87.0606 67.2633 80.637 67.4102L80.6366 67.4102C74.1632 67.562 69.1744 65.4835 67.1854 63.3513C64.2407 60.1868 62.0544 55.9753 61.1744 52.8685L61.0223 52.3317L60.4659 52.2909C60.0915 52.2635 59.8436 52.0979 59.6377 51.7969C59.4083 51.4619 59.2438 50.9684 59.1309 50.3565C59.0197 49.7534 58.9713 49.1137 58.9269 48.5152L58.9261 48.5047C58.9047 48.2168 58.8834 47.9312 58.8553 47.6809C58.8278 47.4369 58.7886 47.1727 58.7159 46.9479C58.6427 46.7213 58.4856 46.3296 58.2989 45.864C58.221 45.6699 58.138 45.463 58.0538 45.2498C57.7553 44.4944 57.4129 43.5928 57.1287 42.6867C56.842 41.7729 56.627 40.8926 56.5649 40.1723C56.4977 39.3935 56.6321 39.0535 56.737 38.9461L56.7395 38.9435C56.8264 38.8537 56.884 38.834 56.9042 38.8285C56.9284 38.8219 56.9566 38.8208 56.9948 38.8291C57.0363 38.8381 57.0779 38.856 57.1113 38.8746C57.1242 38.8818 57.1335 38.8878 57.1383 38.8911L58.65 40.1149L58.4194 38.1686L58.4194 38.1686L58.4194 38.1685L58.4192 38.1672L58.4185 38.1615L58.4157 38.137L58.4047 38.0374C58.395 37.9489 58.3811 37.8172 58.3644 37.6463C58.3308 37.3045 58.2857 36.8066 58.24 36.186C58.1485 34.9442 58.055 33.2147 58.0467 31.2652C58.0299 27.338 58.3606 22.6262 59.6819 19.1951L101.148 38.2654ZM101.148 38.2654L101.148 38.2652L101.148 38.264L101.149 38.2582L101.151 38.2335L101.162 38.133C101.172 38.0438 101.186 37.911 101.202 37.7388C101.236 37.3944 101.28 36.8926 101.325 36.2675C101.416 35.0166 101.508 33.275 101.515 31.3135C101.528 27.3617 101.195 22.6262 99.8734 19.1951M101.148 38.2654L99.8734 19.1951M99.8734 19.1951C97.8078 13.8411 91.3981 6.42642 79.7896 6.42642H79.7895H79.7895H79.7894H79.7894H79.7893H79.7893H79.7892H79.7892H79.7892H79.7891H79.7891H79.789H79.789H79.7889H79.7889H79.7888H79.7888H79.7887H79.7887H79.7886H79.7886H79.7885H79.7885H79.7885H79.7884H79.7884H79.7883H79.7883H79.7882H79.7882H79.7881H79.7881H79.788H79.788H79.7879H79.7879H79.7878H79.7878H79.7878H79.7877H79.7877H79.7876H79.7876H79.7875H79.7875H79.7874H79.7874H79.7873H79.7873H79.7872H79.7872H79.7872H79.7871H79.7871H79.787H79.787H79.7869H79.7869H79.7868H79.7868H79.7867H79.7867H79.7866H79.7866H79.7866H79.7865H79.7865H79.7864H79.7864H79.7863H79.7863H79.7862H79.7862H79.7861H79.7861H79.786H79.786H79.7859H79.7859H79.7859H79.7858H79.7858H79.7857H79.7857H79.7856H79.7856H79.7855H79.7855H79.7854H79.7854H79.7853H79.7853H79.7853H79.7852H79.7852H79.7851H79.7851H79.785H79.785H79.7849H79.7849H79.7848H79.7848H79.7847H79.7847H79.7847H79.7846H79.7846H79.7845H79.7845H79.7844H79.7844H79.7843H79.7843H79.7842H79.7842H79.7841H79.7841H79.7841H79.784H79.784H79.7839H79.7839H79.7838H79.7838H79.7837H79.7837H79.7836H79.7836H79.7835H79.7835H79.7834H79.7834H79.7834H79.7833H79.7833H79.7832H79.7832H79.7831H79.7831H79.783H79.783H79.7829H79.7829H79.7828H79.7828H79.7828H79.7827H79.7827H79.7826H79.7826H79.7825H79.7825H79.7824H79.7824H79.7823H79.7823H79.7822H79.7822H79.7822H79.7821H79.7821H79.782H79.782H79.7819H79.7819H79.7818H79.7818H79.7817H79.7817H79.7816H79.7816H79.7816H79.7815H79.7815H79.7814H79.7814H79.7813H79.7813H79.7812H79.7812H79.7811H79.7811H79.781H79.781H79.781H79.7809H79.7809H79.7808H79.7808H79.7807H79.7807H79.7806H79.7806H79.7805H79.7805H79.7804H79.7804H79.7803H79.7803H79.7803H79.7802H79.7802H79.7801H79.7801H79.78H79.78H79.7799H79.7799H79.7798H79.7798H79.7797H79.7797H79.7797H79.7796H79.7796H79.7795H79.7795H79.7794H79.7794H79.7793H79.7793H79.7792H79.7792H79.7791H79.7791H79.7791H79.779H79.779H79.7789H79.7789H79.7788H79.7788H79.7787H79.7787H79.7786H79.7786H79.7785H79.7785H79.7784H79.7784H79.7784H79.7783H79.7783H79.7782H79.7782H79.7781H79.7781H79.778H79.778H79.7779H79.7779H79.7778H79.7778H79.7777H79.7777H79.7777H79.7776H79.7776H79.7775H79.7775H79.7774H79.7774H79.7773H79.7773H79.7772H79.7772H79.7771H79.7771H79.7771H79.777H79.777H79.7769H79.7769H79.7768H79.7768H79.7767H79.7767H79.7766H79.7766H79.7765H79.7765H79.7764H79.7764H79.7764H79.7763H79.7763H79.7762H79.7762H79.7761H79.7761H79.776H79.776H79.7759H79.7759H79.7758H79.7758H79.7757H79.7757H79.7757H79.7756H79.7756H79.7755H79.7755H79.7754H79.7754H79.7753H79.7753H79.7752H79.7752H79.7751H79.7751H79.775H79.775H79.775H79.7749H79.7749H79.7748H79.7748H79.7747H79.7747H79.7746H79.7746H79.7745H79.7745H79.7744H79.7744H79.7743H79.7743H79.7743H79.7742H79.7742H79.7741H79.7741H79.774H79.774H79.7739H79.7739H79.7738H79.7738H79.7737H79.7737H79.7736H79.7736H79.7736H79.7735H79.7735H79.7734H79.7734H79.7733H79.7733H79.7732H79.7732H79.7731H79.7731H79.773H79.773H79.7729H79.7729H79.7729H79.7728H79.7728H79.7727H79.7727H79.7726H79.7726H79.7725H79.7725H79.7724H79.7724H79.7723H79.7723H79.7722H79.7722H79.7722H79.7721H79.7721H79.772H79.772H79.7719H79.7719H79.7718H79.7718H79.7717H79.7717H79.7716H79.7716H79.7715H79.7715H79.7715H79.7714H79.7714H79.7713H79.7713H79.7712H79.7712H79.7711H79.7711H79.771H79.771H79.7709H79.7709H79.7708H79.7708H79.7708H79.7707H79.7707H79.7706H79.7706H79.7705H79.7705H79.7704H79.7704H79.7703H79.7703H79.7702H79.7702H79.7701H79.7701H79.77H79.77H79.77H79.7699H79.7699H79.7698H79.7698H79.7697H79.7697H79.7696H79.7696H79.7695H79.7695H79.7694H79.7694H79.7693H79.7693H79.7693H79.7692H79.7692H79.7691H79.7691H79.769H79.769H79.7689H79.7689H79.7688H79.7688H79.7687H79.7687H79.7686H79.7686H79.7686H79.7685H79.7685H79.7684H79.7684H79.7683H79.7683H79.7682H79.7682H79.7681H79.7681H79.768H79.768H79.7679H79.7679H79.7679H79.7678H79.7678H79.7677H79.7677H79.7676H79.7676H79.7675H79.7675H79.7674H79.7674H79.7673H79.7673H79.7672H79.7672H79.7672H79.7671H79.7671H79.767H79.767H79.7669H79.7669H79.7668H79.7668H79.7667H79.7667H79.7666H79.7666H79.7666H79.7665H79.7665H79.7664H79.7664H79.7663H79.7663H79.7662H79.7662H79.7661H79.7661H79.766H79.766H79.7659H79.7659H79.7659H79.7658H79.7658C68.1575 6.42642 61.7479 13.8407 59.6821 19.1946L99.8734 19.1951Z"
                                    fill="#9AA0A9" stroke="#F6F9FE" stroke-width="1.59368" />
                                <path
                                    d="M72.5768 65.093C72.0764 61.5907 80.2434 64.8349 80.2434 64.8349C80.2434 64.8349 79.9253 86.639 79.9813 89.1367C77.2056 84.459 73.2661 69.9136 72.5768 65.093Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M87.3928 65.093C87.8931 61.5907 79.7266 64.8349 79.7266 64.8349C79.7266 64.8349 80.0442 86.639 79.9886 89.1367C82.7639 84.459 86.7038 69.9136 87.3928 65.093Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M82.0508 95.4414C85.8612 85.9192 85.1389 70.2541 92.4033 65.0721C92.6137 68.0224 93.0632 73.5658 92.5109 76.1667C91.5571 80.6658 87.4258 89.0205 82.0508 95.4414Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M77.9123 95.4414C74.1018 85.9192 74.8249 70.2541 67.5606 65.0721C67.3497 68.0224 66.9002 73.5658 67.4522 76.1667C68.4064 80.6658 72.5373 89.0205 77.9123 95.4414Z"
                                    fill="#9AA0A9" />
                            </g>
                            <g class="upper-extremity js-body-area" data-body-part="upper-extremity">
                                <path
                                    d="M58.878 94.3104C52.3919 92.4878 45.7546 87.7306 41.8163 86.9007C37.1318 85.9199 29.0098 89.72 25.2545 96.0337C22.6269 100.449 19.7576 109.61 21.6505 119.637C33.0069 116.77 33.0446 107.537 39.6696 102.05C44.0038 98.46 54.242 95.0172 58.878 94.3104Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M39.0169 106.403C39.7265 121.436 33.705 155.313 28.0132 166.795C26.3938 167.884 22.4138 167.799 21.3341 166.71C19.1752 157.998 19.8307 130.601 21.8646 122.397C28.0163 121.683 32.7413 116.119 39.0169 106.403Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M37.823 136.327C38.9753 143.903 35.9999 167.246 29.8125 166.974C31.5788 162.959 37.1352 141.773 37.823 136.327Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M18.0318 169.224C25.7536 176.264 18.6151 196.367 14.3989 221.584C12.9936 229.99 12.3447 239.584 11.8154 248.212C11.3226 248.682 10.8251 248.413 10.3446 248.146C9.91095 224.98 11.9754 191.027 18.0318 169.224Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M32.5571 169.685C31.6156 171.486 29.8223 174.839 28.5711 179.394C25.2046 191.649 17.9478 227.682 14.4728 248.634C13.9388 249.061 13.2455 248.732 12.8047 248.379C16.2137 222.809 20.8553 188.375 23.916 178.27C25.2618 173.828 30.1511 172.088 32.5571 169.685Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M35.6358 166.689C35.4432 173.434 34.9556 177.75 33.9013 183.84C31.2936 198.901 20.3463 233.315 17.6719 249.11C17.1378 249.377 16.3432 249.212 16.0156 248.751C20.5043 225.758 26.0175 192.673 30.2397 179.022C31.9949 173.347 34.2865 170.929 35.6358 166.689Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M11.4229 269.612C12.4728 266.873 13.1705 260.453 13.0021 255.465C13.0021 255.465 10.1443 254.641 9.0189 254.579C6.47277 262.502 -2.8326 277.437 10.5136 288.699C4.92215 277.27 10.1772 272.864 11.4229 269.612Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M18.5176 266.629C18.1547 263.209 16.9936 259.272 15.3171 255.847C14.5062 259.101 13.4047 266.009 13.9582 268.612C14.5813 271.546 15.8273 273.13 15.6709 278.531C16.8157 275.734 18.8802 270.049 18.5176 266.629Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M101.102 94.3104C107.588 92.4878 114.225 87.7306 118.163 86.9007C122.847 85.9199 130.969 89.72 134.725 96.0337C137.353 100.449 140.222 109.61 138.329 119.637C126.972 116.77 126.935 107.537 120.31 102.05C115.976 98.46 105.738 95.0172 101.102 94.3104Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M120.94 106.403C120.23 121.436 126.252 155.313 131.944 166.795C133.563 167.884 137.543 167.799 138.623 166.71C140.782 157.998 140.126 130.601 138.092 122.397C131.941 121.683 127.216 116.119 120.94 106.403Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M122.131 136.327C120.978 143.903 123.954 167.246 130.141 166.974C128.374 162.959 122.818 141.773 122.131 136.327Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M141.939 169.224C134.216 176.264 141.355 196.367 145.571 221.584C146.977 229.99 147.626 239.584 148.155 248.212C148.648 248.682 149.145 248.413 149.626 248.146C150.06 224.98 147.995 191.027 141.939 169.224Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M127.402 169.685C128.344 171.486 130.137 174.839 131.389 179.394C134.755 191.649 142.012 227.682 145.487 248.634C146.021 249.061 146.714 248.732 147.156 248.379C143.746 222.809 139.104 188.375 136.044 178.27C134.698 173.828 129.808 172.088 127.402 169.685Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M124.332 166.689C124.525 173.434 125.012 177.75 126.067 183.84C128.674 198.901 139.622 233.315 142.297 249.11C142.83 249.377 143.625 249.212 143.953 248.751C139.464 225.758 133.951 192.673 129.728 179.022C127.973 173.347 125.681 170.929 124.332 166.689Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M148.553 269.612C147.504 266.873 146.806 260.453 146.974 255.465C146.974 255.465 149.833 254.641 150.958 254.579C153.504 262.502 162.809 277.437 149.463 288.699C155.054 277.27 149.799 272.864 148.553 269.612Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M141.456 266.629C141.819 263.209 142.98 259.272 144.657 255.847C145.468 259.101 146.569 266.009 146.016 268.612C145.392 271.546 144.147 273.13 144.303 278.531C143.158 275.734 141.093 270.049 141.456 266.629Z"
                                    fill="#9AA0A9" />
                            </g>
                            <g class="torso-full js-body-area" data-body-part="torso-full">
                                <path
                                    d="M47 83.4021C50.5047 82.4689 61.0176 79.4312 64.5219 77.3266C66.6245 82.4689 69.1945 88.1076 71.7644 92.7773C65.8959 92.2691 53.5416 88.5404 47 83.4021Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M112.955 83.4021C109.451 82.4689 98.9378 79.4312 95.4335 77.3266C93.3309 82.4689 90.761 88.1076 88.1914 92.7773C94.0596 92.2691 106.414 88.5404 112.955 83.4021Z"
                                    fill="#9AA0A9" />
                            </g>
                            <g class="torso internal-organs js-body-area" data-body-part="internal-organs">
                                <path
                                    d="M40.5977 104.595C49.7641 99.0954 65.7028 97.2609 74.0544 100.318C80.1656 108.26 78.6102 139.551 78.6102 139.551C78.6102 139.551 57.765 143.261 50.5793 138.205C43.9435 133.535 40.5977 118.446 40.5977 104.595Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M41.0326 112.161C39.0185 124.582 41.5821 135.995 44.6361 139.572C49.2309 144.958 64.537 146.906 70.2976 138.79C75.1306 131.98 74.2836 119.158 68.421 114.651C61.9568 109.684 46.7673 108.802 41.0326 112.161Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M45.0941 134.559C47.6227 142.218 55.835 143.343 55.835 143.343V152.969C55.835 152.969 49.7853 151.571 47.1991 147.825C45.1946 144.921 44.8987 141.689 45.0941 134.559Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M45.8486 147.82C47.9881 155.097 55.8258 156.885 55.8258 156.885V164.617C55.8258 164.617 49.8135 163.003 47.6724 159.841C45.982 157.344 45.2653 153.505 45.8486 147.82Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M46.672 160.134C48.6336 166.807 55.8197 168.446 55.8197 168.446V175.535C55.8197 175.535 50.3069 174.056 48.3441 171.156C46.7943 168.867 46.1367 165.347 46.672 160.134Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M48.1848 173.368C49.8264 179.583 55.8399 181.109 55.8399 181.109V187.711C55.8399 187.711 51.2269 186.333 49.5841 183.633C48.2872 181.502 47.7373 178.223 48.1848 173.368Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M37.6719 215.151C40.9582 222.709 56.5435 245.61 64.4682 252.559C55.799 226.251 59.038 204.24 54.7391 197.746C52.1609 193.852 50.4558 191.139 47.1587 186.572C46.251 197.191 39.5962 200.077 37.6719 215.151Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M78.5827 142.342C78.5827 142.342 78.5827 152.901 78.5827 154.799C71.6213 155.207 63.2428 157.719 58.0234 160.73C58.0234 158.231 58.0234 143.232 58.0234 143.232L78.5827 142.342Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M78.5827 157.942C71.0146 158.355 62.8338 160.989 58.0234 163.983C58.0234 166.207 58.0234 176.734 58.0234 176.734L78.5827 176.215C78.5827 176.215 78.5827 159.806 78.5827 157.942Z"
                                    fill="#9AA0A9" />
                                <path d="M58.0234 179.384L58.5738 192.629H78.5827V179.384H58.0234Z" fill="#9AA0A9" />
                                <path
                                    d="M58.793 195.811C61.3427 195.894 78.5994 195.811 78.5994 195.811C78.5994 195.811 78.5994 258.728 78.5994 259.469C75.6748 259.455 70.1259 256.964 68.0249 255.295C67.8613 254.887 58.793 220.377 58.793 195.811Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M119.388 104.595C110.222 99.0954 94.2829 97.2609 85.9313 100.318C79.8205 108.26 81.3763 139.551 81.3763 139.551C81.3763 139.551 102.221 143.261 109.407 138.205C116.042 133.535 119.388 118.446 119.388 104.595Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M119.02 112.161C121.033 124.582 118.47 135.995 115.416 139.572C110.822 144.958 95.5155 146.906 89.7546 138.79C84.9216 131.98 85.7686 119.158 91.6312 114.651C98.0954 109.684 113.285 108.802 119.02 112.161Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M114.874 134.559C112.345 142.218 104.133 143.343 104.133 143.343V152.969C104.133 152.969 110.182 151.571 112.769 147.825C114.773 144.921 115.069 141.689 114.874 134.559Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M114.11 147.82C111.971 155.097 104.133 156.885 104.133 156.885V164.617C104.133 164.617 110.146 163.003 112.286 159.841C113.977 157.344 114.694 153.505 114.11 147.82Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M113.281 160.134C111.319 166.807 104.133 168.446 104.133 168.446V175.535C104.133 175.535 109.646 174.056 111.608 171.156C113.159 168.867 113.816 165.347 113.281 160.134Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M111.788 173.368C110.147 179.583 104.133 181.109 104.133 181.109V187.711C104.133 187.711 108.746 186.333 110.389 183.633C111.686 181.502 112.236 178.223 111.788 173.368Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M122.3 215.151C119.014 222.709 103.429 245.61 95.5039 252.559C104.173 226.251 100.934 204.24 105.233 197.746C107.811 193.852 109.516 191.139 112.813 186.572C113.721 197.191 120.376 200.077 122.3 215.151Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M81.375 142.342C81.375 142.342 81.375 152.901 81.375 154.799C88.3364 155.207 96.7141 157.719 101.933 160.73C101.933 158.231 101.933 143.232 101.933 143.232L81.375 142.342Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M81.375 157.942C88.9423 158.355 97.1239 160.989 101.933 163.983C101.933 166.207 101.933 176.734 101.933 176.734L81.375 176.215C81.375 176.215 81.375 159.806 81.375 157.942Z"
                                    fill="#9AA0A9" />
                                <path d="M101.933 179.384L101.383 192.629H81.375V179.384H101.933Z" fill="#9AA0A9" />
                                <path
                                    d="M101.181 195.811C98.6313 195.894 81.375 195.811 81.375 195.811C81.375 195.811 81.375 258.728 81.375 259.469C84.2992 259.455 89.8477 256.964 91.9491 255.295C92.1127 254.887 101.181 220.377 101.181 195.811Z"
                                    fill="#9AA0A9" />
                            </g>
                            <g class="lower-extremity js-body-area" data-body-part="lower-extremity">
                                <path
                                    d="M33.8572 234.615C38.749 249.056 51.1048 272.767 54.2382 297.127C55.3095 305.454 52.5454 318.169 50.2959 325.745C48.5821 331.098 44.9138 330.022 44.3614 326.988C41.7629 314.615 33.9553 302.301 32.2685 290.867C29.3963 271.398 30.1687 252.321 33.8572 234.615Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M35.7438 223.471C45.056 240.922 67.8342 275.371 69.2657 309.665C69.8387 323.377 69.2875 373.14 55.5959 380.387C63.65 363.741 66.1894 331.839 63.9943 313.279C61.0408 288.311 42.0428 253.447 34.875 226.956C34.9032 225.888 35.1132 224.207 35.7438 223.471Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M59.6953 257.472C64.618 261.847 71.4551 264.719 73.3691 269.368C75.5872 274.754 73.9163 290.973 72.0019 296.441C69.5407 278.803 62.4301 265.266 59.6953 257.472Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M34.4609 308.747C33.0905 301.21 43.7996 330.142 44.1459 336.11C44.4163 340.78 40.7635 346.852 40.553 343.27C40.092 335.419 35.6212 318.031 34.4609 308.747Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M57.5015 296.469C57.5015 296.469 69.372 343.719 54.8727 342.476C43.3707 341.491 57.5015 322.101 57.5015 296.469Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M42.628 374.302C31.577 413.32 46.1728 454.605 45.9624 469.889C45.9159 473.272 48.8802 473.666 49.0946 469.933C49.8852 456.158 51.4537 398.362 42.628 374.302Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M63.5743 379.381C45.6425 400.896 54.9999 425.487 53.1189 469.981C52.9922 472.963 56.215 473.003 56.2555 470.025C56.4406 456.603 67.3736 399.017 63.5743 379.381Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M46.6175 478.256C43.3042 485.646 35.1357 493.913 29.7031 497.368C31.9364 501.315 36.1102 503.503 39.678 504.523C46.8145 498.916 54.6792 486.92 56.4633 478.764C54.4247 479.531 49.1661 479.018 46.6175 478.256Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M126.103 234.615C121.212 249.056 108.856 272.767 105.722 297.127C104.651 305.454 107.416 318.169 109.665 325.745C111.378 331.098 115.047 330.022 115.599 326.988C118.198 314.615 126.005 302.301 127.692 290.867C130.565 271.398 129.792 252.321 126.103 234.615Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M124.222 223.471C114.91 240.922 92.1321 275.371 90.7002 309.665C90.1276 323.377 90.6784 373.14 104.37 380.387C96.3162 363.741 93.7768 331.839 95.9723 313.279C98.9251 288.311 117.923 253.447 125.092 226.956C125.063 225.888 124.853 224.207 124.222 223.471Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M100.266 257.472C95.3436 261.847 88.5066 264.719 86.5922 269.368C84.3741 274.754 86.045 290.973 87.9598 296.441C90.4209 278.803 97.5316 265.266 100.266 257.472Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M102.485 296.469C102.485 296.469 90.6151 343.719 105.114 342.476C116.616 341.491 102.485 322.101 102.485 296.469Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M125.508 308.747C126.878 301.21 116.169 330.142 115.823 336.11C115.552 340.78 119.205 346.852 119.415 343.27C119.876 335.419 124.347 318.031 125.508 308.747Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M117.342 374.302C128.393 413.32 113.797 454.605 114.007 469.889C114.054 473.272 111.09 473.666 110.876 469.933C110.085 456.158 108.516 398.362 117.342 374.302Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M96.4031 379.381C114.335 400.896 104.977 425.487 106.859 469.981C106.985 472.963 103.763 473.003 103.721 470.025C103.537 456.603 92.6034 399.017 96.4031 379.381Z"
                                    fill="#9AA0A9" />
                                <path
                                    d="M113.362 478.256C116.675 485.646 124.844 493.913 130.276 497.368C128.043 501.315 123.869 503.503 120.301 504.523C113.165 498.916 105.3 486.92 103.516 478.764C105.555 479.531 110.813 479.018 113.362 478.256Z"
                                    fill="#9AA0A9" />
                            </g>
                        </g>
                    </svg>
                    <svg width="243" height="504" viewbox="0 0 243 504" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="human-body-areas_male js-human-body-svg">
                        <g class="nerv-system js-body-area" data-body-part="nerv-system">
                            <path
                                d="M78.2027 145.421L78.276 148.58C78.305 149.781 78.3496 150.973 78.4102 152.162C78.5141 154.192 78.7797 156.649 79.037 159.025C79.1586 160.142 79.2719 161.208 79.3677 162.202L79.3726 162.244L79.3677 162.337L80.1189 170.545C80.1668 173.552 80.9868 176.022 82.6268 178.09L83.8273 179.604L83.592 180.251C83.5442 180.382 83.4914 180.509 83.4386 180.64C83.2135 181.19 82.9689 181.786 82.8281 182.492C82.6714 183.283 82.5102 184.074 82.3473 184.865C81.8326 187.381 81.3002 189.978 80.9389 192.617C80.3026 197.286 80.4242 201.299 81.3096 204.877L81.3563 205.059L81.2859 205.232C80.5346 207.122 79.0546 210.912 78.837 211.707C78.5796 212.646 78.1962 213.754 77.7903 214.925C77.3872 216.084 76.9735 217.285 76.6859 218.321L76.1151 220.376C73.1596 231.033 69.8096 243.111 68.9065 253.989C68.6954 256.534 68.3517 259.207 67.9875 262.041C67.3017 267.361 66.5951 272.863 66.8349 277.451C67.1401 283.291 67.7813 287.432 68.5899 292.676L68.6074 292.79C68.9 294.685 69.2151 296.736 69.5457 299.066L78.821 331.05C78.9523 334.344 79.0563 337.702 79.1328 341.031C79.1983 343.889 79.1999 346.693 79.2015 349.658V349.979C79.2032 351.231 79.2048 352.495 79.2097 353.785L79.2334 358.42L79.1774 358.543C75.701 365.88 73.4313 373.924 72.4292 382.458C71.5552 389.901 71.0993 400.977 72.4435 409.723C72.7168 411.499 72.9566 413.131 73.1837 414.671L73.2238 414.946C74.4481 423.277 75.2583 428.783 78.2985 438.172C78.9683 440.235 80.1701 443.039 81.5989 445.868L81.7876 446.241L81.495 446.537C80.896 447.141 80.4769 447.983 80.3796 448.786L80.231 449.979C80.0182 451.645 79.7993 453.366 79.7273 455.13L77.8156 466.959L74.942 470.046C71.3633 474.892 68.4638 477.654 63.8622 480.589C62.8585 481.232 59.0973 484.615 56.6631 487.782C55.287 489.571 53.5271 492.252 54.1376 494.858C54.451 496.198 55.3443 497.272 56.652 497.881C61.378 500.042 66.0182 501.988 70.7908 501.988C75.0586 501.988 78.9986 500.431 82.8363 497.234C83.1448 496.976 83.4419 496.723 83.7361 496.473C85.3486 495.103 86.5844 494.05 88.2849 493.356C88.6671 493.2 89.0779 493.056 89.4965 492.904C92.0363 491.999 95.7799 490.658 96.7754 486.556L98.3373 480.128C98.4588 479.658 98.6106 479.083 98.6617 478.457C98.8708 475.852 99.0468 473.243 99.2227 470.634L99.3618 468.561C99.3938 468.084 99.3983 467.606 99.3762 467.145L99.3729 467.085L99.9339 463.398C99.9625 463.216 99.9944 463.055 100.025 462.916C100.147 462.345 100.284 461.693 100.154 460.894C99.9818 459.833 99.8349 458.763 99.6876 457.689C99.2898 454.779 98.8868 451.836 98.0173 448.968C96.8683 445.175 96.6412 439.318 97.4755 435.042C98.5578 429.498 99.8971 425.658 101.317 421.594C102.712 417.597 104.147 413.487 105.324 407.731C106.525 401.84 106.606 394.667 105.528 389.466C104.871 386.302 104.4 383.499 103.901 380.53L103.876 380.373C103.629 378.919 103.378 377.434 103.097 375.857C103.079 375.552 103.068 375.155 103.052 374.651L103.038 374.148C102.843 367.58 102.752 367.031 102.514 366.405L102.181 365.529L102.867 365.61L103.673 363.66C108.111 352.931 110.646 341.284 111.209 329.045C111.586 320.786 111.201 312.692 110.064 304.991L110.019 304.686L110.363 304.373C111.118 303.68 111.586 302.796 111.754 301.751C111.968 300.415 112.47 298.309 112.956 296.275C113.557 293.763 114.174 291.179 114.43 289.348C116.506 279.384 116.803 276.948 117.682 269.716L118.098 266.257C119.009 258.34 119.226 256.462 119.226 251.455V250.901C119.228 248.144 119.229 245.97 118.745 244.317L118.525 243.568L119.28 243.585C120.385 243.611 124.438 243.513 124.478 243.513L125.196 243.496L125.023 244.215C124.494 246.444 124.267 248.444 124.269 250.901V251.455C124.269 256.458 124.486 258.332 125.396 266.223L125.811 269.695C126.693 276.948 126.989 279.384 129.059 289.309C129.321 291.174 129.937 293.754 130.533 296.254C131.023 298.3 131.527 300.402 131.741 301.751C131.909 302.796 132.377 303.676 133.132 304.373L133.476 304.686L133.431 304.991C132.294 312.7 131.909 320.79 132.288 329.045C132.849 341.28 135.384 352.927 139.822 363.66L140.656 365.606L141.316 365.525L140.981 366.405C140.745 367.031 140.652 367.585 140.457 374.144L140.444 374.605C140.428 375.129 140.416 375.548 140.406 375.781C140.12 377.417 139.871 378.893 139.628 380.344L139.594 380.534C139.095 383.503 138.624 386.307 137.968 389.466C136.891 394.667 136.971 401.84 138.173 407.731C139.351 413.499 140.786 417.606 142.175 421.581C143.596 425.654 144.937 429.494 146.019 435.042C146.855 439.318 146.627 445.175 145.478 448.968C144.608 451.836 144.205 454.779 143.815 457.629C143.66 458.758 143.513 459.833 143.341 460.894C143.211 461.693 143.35 462.345 143.46 462.865C143.503 463.068 143.536 463.22 143.563 463.398L144.124 467.081L144.12 467.14C144.097 467.601 144.101 468.079 144.135 468.561L144.277 470.68C144.451 473.277 144.626 475.869 144.835 478.457C144.886 479.087 145.028 479.629 145.147 480.031L145.168 480.149L146.72 486.556C147.717 490.662 151.462 491.999 153.939 492.883C154.406 493.052 154.823 493.2 155.21 493.356C156.911 494.05 158.146 495.099 159.711 496.431C160.027 496.701 160.339 496.968 160.659 497.234C164.495 500.431 168.435 501.984 172.704 501.988C177.478 501.988 182.128 500.038 186.869 497.869C188.159 497.268 189.044 496.198 189.357 494.858C189.968 492.252 188.21 489.571 186.834 487.782C184.403 484.615 180.64 481.232 179.634 480.589C175.033 477.654 172.133 474.892 168.553 470.042L168.433 469.881L165.681 466.959L163.775 455.202C163.696 453.362 163.477 451.641 163.266 449.975L163.115 448.786C163.02 447.983 162.601 447.141 162 446.537L161.706 446.245L161.896 445.868C163.325 443.039 164.527 440.235 165.197 438.172C168.237 428.787 169.045 423.281 170.271 414.946L170.31 414.688C170.537 413.148 170.778 411.507 171.051 409.723C172.397 400.981 171.94 389.906 171.066 382.458C170.065 373.928 167.794 365.88 164.32 358.543L164.263 358.42L164.286 353.785C164.292 352.39 164.293 351.028 164.293 349.683C164.295 346.697 164.297 343.877 164.362 341.031C164.437 337.723 164.543 334.366 164.674 331.05L164.696 330.915L173.438 299.823C173.609 298.58 173.943 297.133 174.266 295.733C174.526 294.6 174.774 293.534 174.905 292.676C175.715 287.432 176.355 283.291 176.662 277.451C176.902 272.867 176.193 267.365 175.509 262.045C175.145 259.216 174.801 256.543 174.588 253.989C173.685 243.107 170.335 231.029 167.378 220.372L166.809 218.321C166.192 216.088 165.636 214.464 164.827 212.536C163.899 210.315 161.864 205.228 161.864 205.228L161.794 205.05L161.84 204.868C162.18 203.523 162.382 202.242 162.457 200.956C162.791 195.192 162.04 189.124 160.09 181.854C159.933 181.27 159.711 180.813 159.475 180.331L159.195 179.752L160.36 178.259C161.941 176.229 162.767 174.013 162.96 171.286L163.759 162.637L163.892 161.821C164.012 161.111 164.131 160.4 164.214 159.685C164.626 156.171 164.858 152.695 164.923 149.053L164.981 145.962L165.99 148.876C166.814 151.257 167.904 153.663 169.47 157.067C169.958 158.125 170.951 159.787 172.103 161.69C172.367 162.125 172.602 162.514 172.773 162.806C173.033 163.246 173.316 163.644 173.613 163.995L173.853 164.274L173.697 164.612C173.492 165.056 173.382 165.437 173.334 165.623C172.349 169.412 172.819 173.358 174.694 177.033C175.923 179.443 176.42 181.786 176.997 184.501C177.402 186.4 177.817 188.354 178.516 190.447C180.921 197.632 184.132 205.951 187.246 213.868C188.945 218.19 190.983 222.271 192.954 226.221C194.83 229.976 196.769 233.863 198.359 237.867C198.541 238.324 198.735 238.777 198.929 239.233L200.07 241.944L200.57 241.822L200.346 242.76C198.522 248.58 199.304 253.088 202.958 257.833L207.847 264.557C209.537 268.004 211.407 271.539 213.977 274.656C214.284 275.036 214.995 275.912 216.284 276.068C216.947 276.144 217.66 276.191 218.265 276.085L218.671 276.018L218.85 276.402C219.074 276.885 219.301 277.367 219.538 277.84C220.541 279.866 222.447 281.025 224.763 281.025C225.845 281.025 226.794 280.716 227.531 280.132L227.867 279.866L228.834 280.644L229.898 280.67C231.725 280.67 233.295 279.815 234.191 278.327C234.944 277.083 235.11 275.535 234.65 274.081L234.524 273.679L234.859 273.438C236.282 272.423 237.117 271.006 237.206 269.454C237.358 266.879 236.018 264.866 235.04 263.398C234.711 262.899 234.418 262.459 234.214 262.07C232.898 259.571 231.514 257.046 230.208 254.674L229.593 253.557L230.805 253.841C231.351 253.963 234.302 254.64 234.888 254.775L235.401 254.691C238.128 254.247 240.045 252.91 241.098 250.724C241.75 249.366 241.314 247.895 241.163 247.476C240.75 246.313 240.013 245.78 239.466 245.539L238.333 245.031C237.108 244.486 235.881 243.936 234.647 243.407L234.517 243.357L232.186 240.384L230.109 238.24C228.006 236.062 225.87 233.846 223.688 231.727C222.75 230.813 221.646 230.073 220.407 229.528L219.642 229.189L220.415 228.424L219.341 226.496C219.224 226.284 219.101 226.073 218.98 225.866C218.671 225.328 218.432 224.914 218.257 224.542C213.33 213.965 210.534 203.545 209.716 192.68C208.811 180.704 205.157 170.22 198.857 161.525C198.564 161.123 197.953 160.282 197.028 159.673L196.588 159.385L196.846 158.916C198.94 155.088 199.502 150.487 199.347 147.709C199.016 141.784 198.46 138.705 195.997 133.224C194.565 130.036 192.941 127.46 191.031 125.354L190.839 125.138L190.893 124.855C190.946 124.58 190.967 124.314 190.959 124.047C190.909 122.618 190.895 121.15 190.881 119.67L190.879 119.505C190.821 113.458 190.764 107.203 188.63 101.473C187.072 97.2858 182.385 91.8008 178.936 89.1196C173.442 84.8483 169.022 83.9009 162.393 82.8479C161.936 82.7718 161.496 82.7337 161.085 82.7252L160.875 82.6788L153.517 79.3589C152.811 79.0544 152.251 78.8133 151.702 78.5511C148.19 76.8637 144.685 75.1638 141.181 73.4552C141.084 73.4087 140.973 73.3538 140.852 73.303L140.487 73.1422L140.516 72.7362C140.57 71.9538 140.537 71.1505 140.414 70.3512C140.245 69.2262 140.136 68.042 140.021 66.786C139.963 66.1643 139.905 65.5216 139.837 64.8534L139.77 64.2106L138.822 62.6288L139.185 62.3116C140.854 60.8569 141.808 58.7383 141.94 56.1924C142.046 54.1794 142.23 52.1154 142.412 50.1827L142.453 49.7557L142.866 49.6795C145.981 49.1212 147.573 44.7908 148.626 41.9235L148.714 41.6825C148.837 41.3442 148.94 41.0649 149.026 40.8788C150.998 36.5483 150.287 33.8376 146.492 31.2241L144.998 30.1879L144.993 29.8877C144.981 28.9953 144.988 27.8239 144.995 27.0669C145.009 25.2357 145.009 24.4999 144.947 24.0178C144.675 21.9287 144.183 18.8288 143.055 16.0714C139.284 6.85635 130.989 1.13434 121.406 1.13434C119.293 1.13434 117.169 1.42194 115.091 1.9971C109.151 3.62949 102.849 9.30072 100.433 15.1918C98.9731 18.7526 98.1294 22.728 97.9281 27.0035C97.8753 28.12 97.8544 29.1433 97.8638 30.1287L97.8671 30.4712L97.1114 30.8815C95.7365 31.3002 94.4676 32.4251 93.6284 33.9645C92.7331 35.6054 92.5621 37.3477 93.1599 38.7433C94.0662 40.8662 95.0589 43.0949 96.3777 45.9791C96.766 46.8291 97.2484 47.8061 98.0607 48.6012C98.6184 49.1509 99.3966 49.5315 100.255 49.6795L100.669 49.7557L100.711 50.187C100.927 52.5003 101.141 54.8855 101.326 57.2538C101.489 59.3344 102.354 61.0557 103.829 62.2313L104.142 62.4808L103.214 65.2763L103.049 67.2343C102.899 68.9682 102.744 70.7571 102.664 72.563L102.645 72.9689L102.267 73.0831C101.874 73.1973 101.545 73.3495 101.332 73.4552C97.8303 75.1638 94.3252 76.8638 90.8153 78.547C90.2588 78.8134 89.695 79.0587 89.0648 79.3294L87.8536 79.858L81.3976 82.7548C81.1545 82.7759 80.9021 82.8056 80.6447 82.8479C74.0164 83.9009 69.5952 84.8483 64.1036 89.1196C60.6542 91.8008 55.9662 97.2858 54.4093 101.473C52.2754 107.203 52.2181 113.453 52.1604 119.501L52.1588 119.619C52.1461 121.117 52.1318 122.601 52.0823 124.047C52.0725 124.314 52.0933 124.58 52.1461 124.855L52.2022 125.138L52.0086 125.354C50.0986 127.464 48.4729 130.036 47.0424 133.224C44.5795 138.709 44.0231 141.788 43.6924 147.709C43.5374 150.487 44.0984 155.088 46.1938 158.916L46.4511 159.385L46.01 159.673C45.0861 160.277 44.4772 161.119 44.1847 161.525C37.8809 170.224 34.2269 180.704 33.3238 192.68C32.5038 203.545 29.7099 213.965 24.7805 224.542C24.6623 224.795 23.5992 227.472 22.9139 229.211L22.8275 229.426L22.6196 229.515C21.3712 230.065 20.2587 230.809 19.3126 231.727C17.1244 233.854 14.9827 236.074 12.911 238.219L10.7771 240.426L8.48369 243.357L8.35398 243.407C7.12644 243.932 5.90545 244.477 4.68773 245.023L3.54325 245.535C2.99331 245.78 2.25024 246.317 1.83614 247.48C1.68761 247.899 1.25266 249.37 1.90653 250.724C2.95649 252.91 4.87309 254.247 7.6015 254.691L8.11461 254.775L13.4082 253.557L12.7944 254.674C11.4887 257.046 10.1012 259.571 8.78894 262.07C8.57944 262.468 8.28074 262.916 7.96239 263.394C6.98282 264.866 5.64316 266.879 5.79538 269.454C5.88622 271.006 6.7189 272.423 8.14162 273.438L8.47715 273.679L8.35112 274.081C7.89079 275.535 8.05855 277.083 8.80981 278.327C9.69527 279.794 11.3046 280.67 13.1156 280.67H14.1402L15.1345 279.866L15.47 280.132C16.2053 280.716 17.1563 281.025 18.2177 281.025C20.5545 281.025 22.4597 279.866 23.4617 277.845C23.6982 277.367 23.927 276.885 24.1524 276.402L24.3296 276.018L24.7376 276.085C25.319 276.187 26.0273 276.149 26.7434 276.064C28.0061 275.912 28.7189 275.036 29.061 274.614C31.5975 271.539 33.4646 268.004 35.1042 264.642L39.9779 257.917C43.6826 253.109 44.4789 248.575 42.6535 242.752L42.3561 241.805L42.9682 241.948L44.1094 239.233C44.3107 238.764 44.501 238.316 44.6802 237.867C46.2658 233.875 48.2028 229.993 50.0761 226.238C52.0598 222.262 54.0963 218.181 55.7935 213.868C58.9025 205.959 62.1117 197.649 64.5238 190.447C65.2239 188.35 65.6392 186.4 66.0406 184.51C66.6176 181.79 67.1164 179.443 68.3456 177.033C70.2204 173.358 70.6902 169.412 69.7073 165.623C69.6578 165.437 69.5457 165.056 69.3411 164.612L69.186 164.274L69.4258 163.995C69.7233 163.644 70.006 163.246 70.265 162.806C70.4361 162.519 70.6681 162.134 70.9299 161.698C72.0838 159.791 73.0814 158.125 73.5688 157.067C75.2681 153.38 76.3614 150.957 77.2084 148.406L78.2027 145.421ZM172.706 503.121H172.704C168.174 503.121 164.009 501.484 159.97 498.114C159.647 497.847 159.334 497.581 159.024 497.319C157.523 496.042 156.346 495.039 154.807 494.413C154.433 494.261 154.032 494.117 153.621 493.969C150.88 492.992 146.796 491.534 145.655 486.831L144.079 480.301C143.958 479.883 143.798 479.261 143.74 478.555C143.531 475.958 143.357 473.357 143.181 470.76L143.039 468.642C143.005 468.134 142.998 467.627 143.021 467.14L142.478 463.575C142.455 463.423 142.426 463.288 142.401 463.169C142.271 462.556 142.094 461.723 142.258 460.708C142.429 459.655 142.575 458.589 142.72 457.528C143.125 454.576 143.534 451.586 144.429 448.63C145.53 444.997 145.746 439.377 144.944 435.266C143.878 429.802 142.549 425.996 141.144 421.97C139.741 417.957 138.291 413.808 137.099 407.964C135.866 401.929 135.787 394.574 136.894 389.229C137.545 386.091 138.015 383.3 138.512 380.344L138.545 380.149C138.79 378.699 139.039 377.218 139.318 375.654C139.319 375.497 139.332 375.087 139.346 374.571L139.36 374.11C139.525 368.562 139.619 367.191 139.813 366.443L138.817 364.113C134.323 353.248 131.759 341.47 131.192 329.1C130.814 320.879 131.188 312.814 132.301 305.122C131.414 304.268 130.861 303.198 130.659 301.937C130.45 300.635 129.953 298.55 129.47 296.533C128.866 293.999 128.243 291.39 127.979 289.508C125.906 279.574 125.608 277.126 124.724 269.856L124.305 266.367C123.388 258.412 123.171 256.526 123.171 251.455V250.901C123.169 248.647 123.364 246.694 123.796 244.659C122.825 244.685 121.083 244.719 119.977 244.723C120.326 246.402 120.326 248.427 120.324 250.901V251.455C120.324 256.53 120.107 258.421 119.188 266.38L118.774 269.839C117.888 277.126 117.589 279.574 115.51 289.546C115.252 291.394 114.628 294.008 114.025 296.533C113.541 298.563 113.044 300.643 112.837 301.937C112.634 303.198 112.081 304.268 111.195 305.122C112.307 312.806 112.681 320.871 112.303 329.1C111.738 341.475 109.172 353.253 104.682 364.108L103.695 366.489C103.88 367.255 103.975 368.684 104.135 374.114L104.15 374.613C104.165 375.112 104.176 375.506 104.186 375.73C104.459 377.231 104.71 378.72 104.956 380.179L104.982 380.335C105.48 383.291 105.948 386.082 106.601 389.229C107.708 394.574 107.629 401.929 106.398 407.964C105.205 413.8 103.757 417.948 102.357 421.957C100.944 426 99.6176 429.802 98.5513 435.266C97.7489 439.377 97.9645 444.997 99.066 448.63C99.9609 451.586 100.37 454.576 100.767 457.469C100.92 458.594 101.066 459.655 101.237 460.708C101.403 461.719 101.225 462.556 101.107 463.11C101.072 463.279 101.043 463.419 101.017 463.575L100.476 467.145C100.497 467.635 100.492 468.138 100.456 468.642L100.324 470.617C100.142 473.327 99.9658 475.941 99.7547 478.55C99.6974 479.257 99.5374 479.883 99.4159 480.305L99.4015 480.403L97.8417 486.831C96.7005 491.534 92.6198 492.988 89.92 493.957C89.4503 494.122 89.0554 494.261 88.688 494.413C87.1486 495.039 85.9722 496.042 84.4808 497.31C84.1375 497.602 83.8351 497.86 83.5249 498.118C79.4859 501.484 75.3192 503.121 70.7908 503.121C65.8041 503.121 61.0458 501.133 56.2044 498.917C54.577 498.156 53.4661 496.811 53.0717 495.124C52.3458 492.037 54.2833 489.051 55.803 487.076C58.3108 483.811 62.2316 480.297 63.2865 479.625C67.7588 476.766 70.5801 474.08 74.0692 469.356L74.1907 469.192L76.7894 466.422L78.6373 455.012C78.7044 453.269 78.9266 451.523 79.141 449.831L79.2911 448.643C79.4028 447.729 79.8263 446.778 80.4467 446.033C79.0706 443.28 77.9147 440.561 77.2579 438.531C74.1858 429.05 73.3723 423.505 72.1383 415.115L72.0986 414.84C71.8731 413.305 71.6317 411.677 71.36 409.905C69.9966 401.041 70.4569 389.842 71.3391 382.319C72.351 373.708 74.6367 365.58 78.134 358.162L78.1115 353.794C78.1049 352.5 78.1049 351.231 78.1033 349.979V349.658C78.1021 346.702 78.1004 343.906 78.0362 341.06C77.9597 337.762 77.8557 334.433 77.7277 331.168L68.4765 299.311C68.1295 296.905 67.8149 294.862 67.5239 292.968L68.0481 292.765L67.5063 292.853C66.6912 287.58 66.0472 283.414 65.7387 277.51C65.4923 272.816 66.2068 267.264 66.8991 261.888C67.2616 259.072 67.6037 256.412 67.8132 253.891C68.7245 242.908 72.0904 230.771 75.0602 220.063L75.6306 218.004C75.9265 216.938 76.3483 215.72 76.7559 214.544C77.1556 213.39 77.5345 212.303 77.7804 211.398C78.0444 210.434 79.8219 205.934 80.202 204.978C79.3214 201.295 79.2064 197.197 79.8538 192.456C80.2179 189.783 80.7552 187.161 81.2732 184.628C81.4361 183.841 81.5961 183.055 81.7524 182.268C81.9156 181.448 82.1951 180.767 82.3997 180.268C82.475 180.082 82.5228 179.968 82.5662 179.849L82.5773 179.82L81.7765 178.809C79.9753 176.534 79.0739 173.836 79.0211 170.554L79.0194 170.414L78.2698 162.316L78.2743 162.227C78.1802 161.322 78.0652 160.265 77.9499 159.195C77.6863 156.759 77.4195 154.281 77.314 152.221C77.3009 151.95 77.2882 151.684 77.2755 151.409C76.566 153.177 75.6981 155.084 74.5598 157.554C74.0467 158.666 73.0335 160.362 71.8604 162.303C71.5998 162.73 71.371 163.111 71.2016 163.394C70.9762 163.779 70.7335 164.134 70.4794 164.464C70.6214 164.815 70.7127 165.12 70.7671 165.331C71.8236 169.399 71.3215 173.628 69.3157 177.561C68.1569 179.837 67.6725 182.112 67.1131 184.747C66.7056 186.671 66.2837 188.658 65.5595 190.819C63.1412 198.043 59.9255 206.374 56.81 214.295C55.0951 218.655 53.0475 222.761 51.0671 226.728C49.189 230.492 47.2613 234.353 45.695 238.299C45.5129 238.756 45.3193 239.212 45.1262 239.665L43.814 242.782C45.6152 248.829 44.717 253.587 40.8458 258.611L36.033 265.238C34.4139 268.579 32.5087 272.182 29.9002 275.345C29.5373 275.793 28.5671 276.99 26.8694 277.189C26.2908 277.261 25.5686 277.316 24.9708 277.261C24.7965 277.629 24.6205 277.997 24.4401 278.365C23.2412 280.775 20.9813 282.158 18.2386 282.158C17.0748 282.158 16.0216 281.858 15.1537 281.287L14.5191 281.799L13.1173 281.803C10.9228 281.803 8.96489 280.729 7.87769 278.931C7.02292 277.51 6.7815 275.785 7.19518 274.127C5.68653 272.926 4.80434 271.306 4.69877 269.522C4.52446 266.553 5.98851 264.358 7.05647 262.755C7.35845 262.299 7.64119 261.871 7.82369 261.529C8.93911 259.406 10.1045 257.27 11.2297 255.223L8.14939 255.93L7.42882 255.811C4.33092 255.304 2.1414 253.764 0.923268 251.231C0.0746281 249.472 0.618019 247.615 0.805014 247.087C1.35495 245.543 2.36195 244.824 3.10829 244.494L4.25113 243.983C5.43407 243.454 6.6166 242.925 7.80609 242.418L9.9637 239.669L12.1184 237.436C14.2106 235.267 16.3588 233.038 18.5598 230.902C19.5475 229.942 20.6981 229.156 21.9817 228.568C22.3525 227.625 23.6361 224.385 23.7911 224.051C28.6596 213.601 31.4203 203.316 32.2305 192.591C33.1495 180.399 36.8755 169.717 43.3041 160.844C43.5709 160.48 44.1413 159.69 44.9981 159.021C42.9825 155.076 42.4375 150.466 42.5958 147.645C42.9363 141.564 43.5087 138.396 46.0469 132.746C47.4819 129.549 49.1108 126.944 51.0225 124.783C50.9889 124.525 50.9763 124.267 50.984 124.005C51.0336 122.567 51.0479 121.095 51.0622 119.607L51.6121 119.497L51.0638 119.488C51.1199 113.344 51.1809 106.987 53.3847 101.067C55.012 96.6895 59.8727 90.9889 63.4432 88.2104C69.1414 83.7784 73.6809 82.8056 80.4786 81.7272C80.731 81.6849 80.9774 81.6553 81.2171 81.63L88.5648 78.3186C89.2567 78.0183 89.8099 77.7815 90.3517 77.5193C93.86 75.8319 97.3638 74.136 100.863 72.4275C101.04 72.3429 101.288 72.2288 101.585 72.1147C101.67 70.423 101.815 68.7524 101.956 67.1327L102.154 64.9717L102.851 62.8741C101.312 61.5082 100.407 59.6052 100.231 57.3469C100.057 55.1266 99.8586 52.8893 99.6556 50.7113C98.7481 50.483 97.9248 50.0348 97.3045 49.4216C96.3568 48.4954 95.8163 47.4085 95.3834 46.4612C94.0613 43.5686 93.0658 41.3314 92.1562 39.2041C91.4164 37.4745 91.605 35.36 92.6726 33.4062C93.6378 31.6342 95.1195 30.3274 96.7419 29.8115L96.7644 29.7989C96.7611 28.8981 96.7836 27.9591 96.8315 26.9484C97.0393 22.5375 97.9121 18.4313 99.4224 14.7478C101.959 8.56918 108.573 2.61469 114.81 0.897705C116.979 0.301422 119.197 0.00109863 121.406 0.00109863C131.437 0.00109863 140.12 5.98929 144.065 15.6273C145.244 18.5115 145.754 21.713 146.035 23.8698C146.107 24.428 146.109 25.1512 146.093 27.0754C146.088 27.7436 146.08 28.7374 146.088 29.5789L147.103 30.281C151.35 33.2076 152.221 36.523 150.018 41.361C149.942 41.5302 149.851 41.7797 149.742 42.0841L149.653 42.3253C148.554 45.3152 146.914 49.781 143.467 50.7072C143.298 52.5045 143.133 54.4076 143.037 56.2514C142.896 58.9369 141.934 61.208 140.248 62.8531L140.836 63.8342L140.928 64.7349C140.997 65.4073 141.057 66.0544 141.114 66.6803C141.228 67.9152 141.333 69.0823 141.499 70.1734C141.613 70.9219 141.658 71.6789 141.632 72.419C141.637 72.4232 141.642 72.4232 141.648 72.4275C145.152 74.136 148.655 75.8319 152.164 77.5193C152.701 77.7772 153.249 78.0141 153.856 78.2763L155.057 78.8008L161.217 81.5961C161.643 81.6088 162.096 81.6511 162.559 81.7272C169.359 82.8056 173.898 83.7784 179.596 88.2104C183.165 90.9889 188.028 96.6895 189.655 101.067C191.859 106.987 191.92 113.344 191.977 119.497L191.979 119.657C191.991 121.129 192.006 122.584 192.056 124.005C192.063 124.267 192.052 124.525 192.017 124.783C193.927 126.944 195.556 129.549 196.993 132.746C199.531 138.396 200.103 141.56 200.444 147.645C200.602 150.466 200.057 155.076 198.041 159.021C198.898 159.69 199.47 160.48 199.734 160.844C206.162 169.717 209.89 180.395 210.809 192.591C211.618 203.312 214.378 213.601 219.247 224.047C219.408 224.394 219.632 224.779 219.868 225.185C220.048 225.497 220.174 225.713 220.293 225.933L221.794 228.635L221.585 228.843C222.643 229.393 223.6 230.086 224.441 230.902C226.636 233.034 228.776 235.25 230.847 237.398L233.001 239.622L235.195 242.418C236.391 242.93 237.581 243.458 238.769 243.991L239.899 244.494C240.642 244.824 241.645 245.543 242.194 247.087C242.381 247.611 242.928 249.463 242.081 251.231C240.86 253.764 238.67 255.304 235.572 255.811L234.853 255.93L234.752 255.904C234.752 255.904 233.031 255.511 231.773 255.223C232.897 257.27 234.062 259.406 235.177 261.529C235.357 261.867 235.633 262.282 235.926 262.726C237.014 264.358 238.477 266.553 238.302 269.522C238.198 271.306 237.316 272.926 235.807 274.127C236.221 275.785 235.978 277.515 235.123 278.931C234.02 280.758 232.112 281.803 229.885 281.803L228.445 281.773L227.846 281.287C226.979 281.858 225.93 282.158 224.783 282.158C222.02 282.158 219.76 280.775 218.561 278.361C218.381 277.997 218.205 277.629 218.032 277.261C217.429 277.32 216.764 277.265 216.157 277.193C214.434 276.99 213.492 275.827 213.138 275.392C210.497 272.186 208.587 268.575 206.917 265.153L202.09 258.526C198.307 253.616 197.408 248.728 199.203 242.727L197.923 239.69C197.726 239.229 197.53 238.764 197.343 238.294C195.772 234.34 193.842 230.475 191.977 226.741C189.997 222.77 187.948 218.663 186.228 214.295C183.109 206.361 179.892 198.03 177.478 190.815C176.758 188.663 176.336 186.675 175.928 184.755C175.365 182.108 174.883 179.837 173.724 177.561C171.716 173.628 171.214 169.399 172.274 165.327C172.327 165.119 172.418 164.815 172.56 164.464C172.304 164.134 172.061 163.779 171.836 163.394C171.667 163.107 171.435 162.722 171.171 162.29C170.001 160.358 168.991 158.666 168.48 157.554C167.449 155.317 166.622 153.502 165.938 151.84C165.825 154.534 165.614 157.169 165.304 159.82C165.217 160.552 165.097 161.284 164.974 162.016L164.848 162.785L164.054 171.378C163.846 174.335 162.943 176.749 161.215 178.97L160.493 179.896C160.724 180.374 160.972 180.898 161.148 181.549C163.131 188.942 163.895 195.129 163.553 201.024C163.477 202.327 163.279 203.621 162.948 204.97C163.314 205.879 165.011 210.116 165.834 212.083C166.665 214.062 167.235 215.724 167.864 218.008L168.433 220.059C171.405 230.767 174.771 242.9 175.683 253.891C175.893 256.42 176.235 259.08 176.598 261.893C177.288 267.268 178.003 272.82 177.758 277.51C177.448 283.414 176.805 287.58 175.99 292.853C175.851 293.754 175.6 294.841 175.334 295.996C175.015 297.37 174.687 298.791 174.509 300.06L165.769 331.164C165.638 334.454 165.535 337.783 165.459 341.06C165.395 343.889 165.393 346.706 165.392 349.683C165.392 351.028 165.39 352.394 165.383 353.79L165.363 358.162C168.858 365.584 171.144 373.713 172.156 382.319C173.04 389.846 173.498 401.041 172.137 409.905C171.863 411.681 171.622 413.318 171.395 414.857L171.357 415.119C170.123 423.509 169.308 429.054 166.239 438.531C165.58 440.561 164.424 443.28 163.048 446.038C163.669 446.782 164.094 447.729 164.205 448.643L164.354 449.831C164.568 451.518 164.791 453.265 164.865 455.083L166.707 466.422L169.426 469.356C172.915 474.08 175.738 476.77 180.211 479.625C181.267 480.301 185.187 483.816 187.694 487.076C189.212 489.055 191.149 492.037 190.425 495.124C190.029 496.811 188.926 498.152 187.316 498.905C182.462 501.125 177.694 503.121 172.706 503.121Z"
                                fill="#8D939F" />
                        </g>
                        <g class="skin" data-body-part="skin">
                            <g class="head-and-neck js-body-area" data-body-part="head-and-neck">
                                <path
                                    d="M110.078 64.5429C109.05 64.1935 108.1 63.5884 106.787 62.9405L105.882 65.7064C105.688 68.0931 105.453 70.4799 105.358 72.8751C105.329 73.5826 105.588 74.3795 105.919 75.0188C107.86 78.7778 110.217 82.2513 113.069 85.2943C114.596 86.9223 116.417 88.2778 118.223 89.5777C119.277 90.3363 119.803 89.9868 119.842 88.6614C119.892 86.9864 119.925 85.2815 119.73 83.6236C119.209 79.1997 117.686 75.0914 116.146 70.9573C114.968 67.7907 113.18 65.5914 110.078 64.5429Z"
                                    fill="#8D939F" />
                                <path
                                    d="M123.113 88.7361C123.112 89.9782 123.573 90.259 124.53 89.6932C125.841 88.9147 127.266 88.1447 128.261 87.0089C130.658 84.2566 132.903 81.3468 135.078 78.3988C136.708 76.1868 138 73.7833 137.546 70.7587C137.279 68.9678 137.164 67.1515 136.957 65.0925L135.924 63.344C134.061 64.0289 132.375 64.8033 130.77 65.7306C129.894 66.2369 128.841 66.8281 128.408 67.6831C126.135 72.1923 124.289 76.9099 123.476 81.9636C123.119 84.1842 123.118 86.4772 123.113 88.7361Z"
                                    fill="#8D939F" />
                                <path
                                    d="M116.181 68.7942C118.282 73.793 120.011 78.8942 120.443 84.3746C120.475 84.7837 120.579 85.2182 120.762 85.5804C120.913 85.883 121.23 86.0962 121.472 86.3477C121.717 86.092 122.07 85.8747 122.186 85.5636C122.389 85.0224 122.504 84.43 122.56 83.8504C123.014 79.1201 124.381 74.6454 126.18 70.2943C126.521 69.4633 126.828 68.6236 127.149 67.7883H115.852C115.957 68.1122 116.041 68.466 116.181 68.7942Z"
                                    fill="#8D939F" />
                                <path
                                    d="M98.9755 44.7944C99.2672 45.4322 99.5907 46.1037 100.069 46.5726C100.381 46.8809 101.022 46.9949 101.472 46.9188L103.267 46.9696C103.587 50.3233 103.901 53.6811 104.164 57.0391C104.282 58.547 104.937 59.6959 106.183 60.3802C110.447 62.7286 115.398 66.1751 120.512 66.1836C126.132 66.1962 131.679 63.4466 136.52 60.7772C138.268 59.8184 139.086 58.1668 139.198 56.0549C139.352 53.0602 139.666 50.0699 139.948 47.0836L141.749 46.864C144.051 47.6623 145.841 41.1914 146.515 39.7089C147.889 36.6846 147.605 35.4597 144.942 33.6223L142.415 31.8652C142.076 31.6328 142.327 25.3183 142.214 24.4525C141.905 22.066 141.43 19.4683 140.518 17.2382C136.371 7.07993 126.038 2.0113 115.865 4.81591C110.79 6.21399 105.147 11.2826 103.066 16.3596C101.653 19.8147 100.958 23.4724 100.783 27.1936C100.704 28.8705 100.692 30.5304 100.792 32.165L98.26 33.5885C96.8085 33.7786 95.2277 36.296 95.7997 37.6349C96.8244 40.0383 97.892 42.4206 98.9755 44.7944Z"
                                    fill="#8D939F" />
                            </g>
                            <g class="upper-extremity js-body-area" data-body-part="upper-extremity">
                                <path
                                    d="M52.5922 177.323C52.6142 178.256 52.785 179.186 52.9129 180.355C53.1792 180.026 53.2895 179.925 53.361 179.798C54.8566 177.184 56.1442 174.409 57.882 171.976C61.6142 166.743 64.332 161.025 66.3076 154.896C67.4277 151.416 68.5495 147.936 69.5692 144.422C71.5925 137.449 72.8949 130.324 73.4643 123.068C73.6943 120.15 72.0219 118.76 69.349 119.749C62.0419 122.447 54.9297 122.583 49.5663 134.527C47.2493 139.683 46.7868 142.348 46.4723 147.961C46.3097 150.875 47.1696 155.956 49.5663 159.052C52.8679 163.318 52.4611 171.782 52.5922 177.323Z"
                                    fill="#8D939F" />
                                <path
                                    d="M66.2831 163.004C66.8958 162.949 67.5683 162.03 67.8771 161.509C68.6138 160.264 70.4586 157.33 71.0651 156.017C74.1069 149.454 75.0878 147.26 76.3347 140.621C76.4776 139.859 76.8185 134.896 76.6806 134.138C76.5904 133.643 76.669 131.119 76.6114 130.573C76.2638 127.296 75.6396 122.676 75.4321 123.087C74.8774 125.657 72.7139 137.39 72.3342 138.745C70.6756 144.644 69.0976 150.568 67.5135 156.491C67.0535 158.206 66.6656 159.942 66.2444 161.67C66.3939 161.772 66.1044 163.021 66.2831 163.004Z"
                                    fill="#8D939F" />
                                <path
                                    d="M28.3725 226.477C32.3261 221.838 35.7596 216.804 38.8342 211.512C45.513 200.008 50.1279 187.785 51.1343 174.294C51.4079 170.633 51.4949 167.036 49.8655 163.608C48.7887 161.341 47.7729 161.197 46.3161 163.197C39.8933 172.014 36.7449 182.107 35.9236 192.928C35.0434 204.542 31.9395 215.436 27.0559 225.863C26.7097 226.6 26.2688 227.291 25.8711 228.003C25.9951 228.126 26.1188 228.244 26.2412 228.367C26.9578 227.74 27.7626 227.198 28.3725 226.477Z"
                                    fill="#8D939F" />
                                <path
                                    d="M65.8799 175.849C67.3567 172.933 67.8561 169.751 67.0116 166.484C66.8688 165.938 66.5062 165.252 66.0659 165.049C65.759 164.905 65.0216 165.354 64.6891 165.735C63.3478 167.283 62.0981 168.913 60.7978 170.5C57.9219 174.012 55.2116 177.702 53.4487 181.926C51.4363 186.741 49.8101 191.743 48.1774 196.724C43.9951 209.483 41.2197 222.542 40.7965 236.067C40.768 236.96 40.9206 237.857 40.9906 238.75C41.1416 238.788 41.2925 238.822 41.4452 238.855C41.7076 238.225 41.9827 237.599 42.2322 236.964C45.5131 228.653 50.0294 221.281 53.2818 212.957C56.1256 205.683 59.4468 197.08 61.9137 189.665C63.5322 184.799 63.5623 180.419 65.8799 175.849Z"
                                    fill="#8D939F" />
                                <path
                                    d="M39.1149 237.718C39.3665 232.84 39.9003 227.97 40.3208 223.1C40.3828 222.394 40.4451 221.687 40.5055 220.981L42.0205 212.949L42.0188 212.953C42.1493 212.368 42.2627 211.78 42.3679 211.187C42.4552 210.695 42.3805 210.173 42.3805 209.399C37.9185 215.955 33.6448 222.242 29.3695 228.525L26.4175 231.452C24.5045 231.73 22.7156 232.487 21.3168 233.845C18.4786 236.595 15.7529 239.476 12.9909 242.315L10.3431 245.679L10.3513 245.683C8.48891 246.461 6.64773 247.294 4.80287 248.114C4.56391 248.219 4.38571 249.093 4.54515 249.426C5.26328 250.914 6.57433 251.575 8.19775 251.835C10.7273 251.259 13.3111 250.679 15.8883 250.065L18.1377 250.965C18.0692 251.07 18.0023 251.175 17.9256 251.301C17.8188 251.478 17.7201 251.659 17.623 251.84C15.5266 255.658 13.3906 259.451 11.3581 263.307C10.388 265.149 8.5721 266.903 8.70259 269.132C8.75357 269.994 9.39706 270.621 9.91007 270.978C10.1331 271.129 10.9406 270.536 11.3883 270.162C11.7818 269.83 12.0828 269.355 12.3519 268.901C14.3334 265.536 16.3104 262.168 18.26 258.783C19.1588 257.222 20.0396 255.654 20.8744 254.06L21.5321 254.872C19.423 258.635 17.2948 262.391 15.2701 266.205C13.8444 268.892 12.5668 271.668 11.2607 274.422C10.525 275.974 11.3867 277.681 13.3478 277.635C13.7556 277.307 14.6825 276.853 15.1796 276.096C16.1004 274.7 16.7659 273.127 17.5435 271.63C19.6873 267.496 21.8266 263.362 23.985 259.237L24.7162 260.557C23.1393 263.471 21.5717 266.398 20.0906 269.367C19.0263 271.504 18.072 273.699 17.1386 275.898C16.5811 277.214 17.0831 277.992 18.3603 277.988C19.5902 277.992 20.5795 277.5 21.1468 276.361C21.8792 274.885 22.5182 273.362 23.2318 271.878C24.538 269.166 25.8425 266.449 27.198 263.762L28.2305 264.918C28.0837 265.166 27.9484 265.427 27.8289 265.709C26.9623 267.753 25.8552 269.683 24.9282 271.701C24.7562 272.076 24.8022 272.946 24.9776 273.022C25.4315 273.215 26.0179 273.14 26.5386 273.072C26.7364 273.051 26.9256 272.791 27.0785 272.601C29.5016 269.67 31.2458 266.319 32.9042 262.912L32.9312 262.9L37.9075 256.066C41.213 251.785 41.6351 248.105 39.9256 243.08C39.3523 241.394 39.024 239.493 39.1149 237.718Z"
                                    fill="#8D939F" />
                                <path
                                    d="M169.525 123.068C170.095 130.324 171.395 137.449 173.42 144.422C174.44 147.936 175.562 151.416 176.682 154.896C178.657 161.025 181.373 166.743 185.107 171.976C186.845 174.409 188.133 177.184 189.628 179.798C189.7 179.925 189.81 180.026 190.077 180.355C190.204 179.186 190.375 178.256 190.396 177.323C190.528 171.782 190.121 163.318 193.423 159.052C195.82 155.956 196.68 150.875 196.517 147.961C196.202 142.348 195.738 139.683 193.423 134.527C188.058 122.583 180.946 122.447 173.639 119.749C170.968 118.76 169.295 120.15 169.525 123.068Z"
                                    fill="#8D939F" />
                                <path
                                    d="M176.699 163.004C176.878 163.021 176.588 161.772 176.736 161.67C176.317 159.942 175.929 158.206 175.469 156.491C173.884 150.568 172.306 144.644 170.648 138.745C170.267 137.39 168.103 125.657 167.55 123.087C167.343 122.676 166.719 127.296 166.371 130.573C166.313 131.119 166.392 133.643 166.302 134.138C166.164 134.896 166.504 139.859 166.648 140.621C167.894 147.26 168.876 149.454 171.917 156.017C172.524 157.33 174.369 160.264 175.105 161.509C175.414 162.03 176.087 162.949 176.699 163.004Z"
                                    fill="#8D939F" />
                                <path
                                    d="M193.135 163.608C191.506 167.036 191.593 170.633 191.865 174.294C192.873 187.785 197.488 200.008 204.167 211.512C207.241 216.804 210.675 221.838 214.626 226.477C215.238 227.198 216.043 227.74 216.758 228.367C216.881 228.244 217.005 228.126 217.129 228.003C216.732 227.291 216.291 226.6 215.945 225.863C211.061 215.436 207.957 204.542 207.077 192.928C206.256 182.107 203.107 172.014 196.683 163.197C195.228 161.197 194.212 161.341 193.135 163.608Z"
                                    fill="#8D939F" />
                                <path
                                    d="M194.811 196.724C193.179 191.743 191.552 186.741 189.54 181.926C187.777 177.702 185.066 174.012 182.191 170.5C180.89 168.913 179.641 167.283 178.299 165.735C177.967 165.354 177.229 164.905 176.922 165.049C176.482 165.252 176.12 165.938 175.976 166.484C175.132 169.751 175.632 172.933 177.108 175.849C179.426 180.419 179.456 184.799 181.075 189.665C183.54 197.08 186.863 205.683 189.707 212.957C192.959 221.281 197.475 228.653 200.757 236.964C201.006 237.599 201.28 238.225 201.544 238.855C201.696 238.822 201.847 238.788 201.998 238.75C202.067 237.857 202.219 236.96 202.192 236.067C201.769 222.542 198.994 209.483 194.811 196.724Z"
                                    fill="#8D939F" />
                                <path
                                    d="M238.193 248.114C236.35 247.294 234.507 246.461 232.645 245.683L232.653 245.679L230.005 242.315C227.245 239.476 224.519 236.595 221.679 233.845C220.281 232.487 218.493 231.73 216.579 231.452L213.628 228.525C209.353 222.242 205.078 215.955 200.616 209.399C200.616 210.173 200.541 210.695 200.628 211.187C200.734 211.78 200.849 212.368 200.977 212.953V212.949L202.491 220.981C202.553 221.687 202.615 222.394 202.675 223.1C203.097 227.97 203.63 232.84 203.881 237.718C203.972 239.493 203.644 241.394 203.071 243.08C201.363 248.105 201.785 251.785 205.089 256.066L210.065 262.9L210.092 262.912C211.752 266.319 213.496 269.67 215.918 272.601C216.072 272.791 216.261 273.051 216.457 273.072C216.98 273.14 217.566 273.215 218.02 273.022C218.194 272.946 218.24 272.076 218.068 271.701C217.141 269.683 216.034 267.753 215.169 265.709C215.049 265.427 214.914 265.166 214.767 264.918L215.798 263.762C217.155 266.449 218.46 269.166 219.766 271.878C220.478 273.362 221.117 274.885 221.85 276.361C222.417 277.5 223.406 277.992 224.636 277.988C225.913 277.992 226.417 277.214 225.857 275.898C224.924 273.699 223.971 271.504 222.905 269.367C221.424 266.398 219.858 263.471 218.28 260.553L219.012 259.237C221.169 263.362 223.31 267.496 225.453 271.63C226.23 273.127 226.897 274.7 227.816 276.096C228.315 276.853 229.241 277.307 229.649 277.635C231.609 277.681 232.473 275.974 231.735 274.422C230.429 271.668 229.153 268.892 227.726 266.205C225.701 262.391 223.575 258.635 221.464 254.872L222.123 254.06C222.956 255.654 223.838 257.222 224.736 258.783C226.686 262.168 228.663 265.536 230.644 268.901C230.913 269.355 231.216 269.83 231.609 270.162C232.055 270.536 232.863 271.129 233.086 270.978C233.599 270.621 234.244 269.994 234.293 269.132C234.426 266.903 232.61 265.149 231.638 263.307C229.607 259.451 227.469 255.658 225.375 251.84C225.276 251.659 225.177 251.478 225.07 251.301C224.994 251.175 224.927 251.07 224.858 250.965L227.109 250.065C229.685 250.679 232.269 251.259 234.798 251.835C236.422 251.575 237.734 250.914 238.451 249.426C238.61 249.093 238.433 248.219 238.193 248.114Z"
                                    fill="#8D939F" />
                            </g>
                            <g class="torso-full js-body-area" data-body-part="torso-full">
                                <path
                                    d="M89.8024 89.2478C91.7159 88.0061 95.3087 86.4833 97.4369 87.0874C97.461 87.0958 97.477 87.1 97.4979 87.1042C99.0677 87.5782 100.66 87.9894 102.243 88.4215C105.601 89.336 108.972 90.2001 112.338 91.0811C113.083 91.2741 113.83 91.467 114.587 91.5803C114.859 91.6222 115.165 91.4208 115.456 91.3285C115.368 91.0349 115.361 90.6574 115.177 90.4518C113.832 88.9626 112.42 87.5363 111.086 86.0386C108.498 83.1357 105.833 80.2832 104.262 76.6041C103.841 75.6183 103.121 75.7566 102.337 76.1383C98.826 77.8331 95.3119 79.5196 91.7913 81.1935C90.8839 81.6297 89.9527 82.003 88.7827 82.519L83.582 84.8557C83.582 84.8557 88.7397 86.4665 89.8024 89.2478Z"
                                    fill="#8D939F" />
                                <path
                                    d="M137.944 76.6041C136.372 80.2832 133.708 83.1357 131.122 86.0386C129.787 87.5363 128.374 88.9626 127.029 90.4518C126.843 90.6574 126.838 91.0349 126.75 91.3285C127.041 91.4208 127.347 91.6222 127.619 91.5803C128.376 91.467 129.123 91.2741 129.865 91.0811C133.234 90.2001 136.606 89.336 139.963 88.4215C141.546 87.9894 143.138 87.5782 144.708 87.1042C144.729 87.1 144.745 87.0958 144.769 87.0874C146.897 86.4833 150.49 88.0061 152.404 89.2478C153.466 86.4665 158.624 84.8557 158.624 84.8557L153.423 82.519C152.253 82.003 151.322 81.6297 150.414 81.1935C146.894 79.5196 143.38 77.8331 139.869 76.1383C139.085 75.7566 138.364 75.6183 137.944 76.6041Z"
                                    fill="#8D939F" />
                                <path
                                    d="M122.416 133.723C123.357 132.383 124.271 131.023 125.161 129.645C125.471 129.169 125.677 128.625 125.943 128.09C125.834 127.745 125.797 127.391 125.631 127.13C124.605 125.495 123.616 123.831 122.484 122.281C121.672 121.165 121.137 121.173 120.313 122.327C119.194 123.886 118.198 125.55 117.232 127.218C117.028 127.572 117.005 128.272 117.207 128.613C118.258 130.37 119.376 132.093 120.542 133.774C121.109 134.587 121.84 134.549 122.416 133.723Z"
                                    fill="#8D939F" />
                                <path
                                    d="M121.43 101.676C121.619 101.425 121.726 101.341 121.752 101.237C122.43 98.5692 123.467 96.1066 125.263 94.0411C125.479 93.7903 125.442 93.297 125.522 92.9208C125.156 92.8873 124.753 92.7283 124.432 92.8371C122.581 93.4726 120.749 93.5186 118.877 92.9291C118.445 92.7912 117.929 92.9415 117.453 92.9624C117.628 93.4349 117.705 93.9911 117.996 94.359C119.4 96.1401 120.345 98.1553 120.97 100.355C121.085 100.764 121.248 101.157 121.43 101.676Z"
                                    fill="#8D939F" />
                            </g>
                            <g class="torso internal-organs js-body-area" data-body-part="internal-organs">
                                <path
                                    d="M119.096 103.702C118.756 98.9893 116.429 95.4929 112.022 93.808C107.503 92.0809 102.955 90.4047 98.3459 88.9563C94.9114 87.8795 90.4535 91.7051 89.29 94.8552C86.9487 101.198 83.7968 107.114 80.5726 113.004C79.8089 114.402 79.3644 115.994 78.8813 117.535C78.5649 118.544 78.804 119.516 79.5969 120.284C83.8851 124.431 88.555 128.037 94.0593 130.266C98.198 131.943 102.536 132.315 106.979 131.588C113.773 130.469 119.155 123.565 119.426 116.944C119.608 112.54 119.414 108.102 119.096 103.702Z"
                                    fill="#8D939F" />
                                <path
                                    d="M135.63 131.588C140.073 132.315 144.411 131.943 148.55 130.266C154.054 128.037 158.726 124.431 163.012 120.284C163.805 119.516 164.045 118.544 163.728 117.535C163.245 115.994 162.8 114.402 162.036 113.004C158.812 107.114 155.66 101.198 153.319 94.8552C152.156 91.7051 147.698 87.8795 144.263 88.9563C139.654 90.4047 135.107 92.0809 130.588 93.808C126.182 95.4929 123.854 98.9893 123.514 103.702C123.196 108.102 123.002 112.54 123.183 116.944C123.454 123.565 128.837 130.469 135.63 131.588Z"
                                    fill="#8D939F" />
                                <path
                                    d="M84.4295 127.438C84.385 127.417 84.3531 127.408 84.3115 127.392L84.1743 127.336V127.341C82.5685 126.684 82.2398 127.336 81.9813 129.84C81.2239 137.211 80.9369 144.599 81.3133 152.004C81.4632 154.948 81.9797 158.964 82.2847 162.201L82.2831 162.256L83.0245 170.313C83.0262 170.381 83.0196 170.444 83.0213 170.512C83.0531 172.575 83.4998 174.549 84.9035 176.324C85.1203 176.053 85.2273 175.968 85.2653 175.863C85.4041 175.473 85.5286 175.075 85.6434 174.672C86.4012 172.037 87.535 169.614 89.3867 167.598C90.9721 165.873 92.562 164.153 94.1348 162.417C96.5846 159.705 98.3791 156.643 98.894 152.881C99.0136 152.013 99.21 151.157 99.379 150.297C100.272 145.751 101.211 141.214 102.042 136.656C102.424 134.563 101.535 133.496 99.5003 133.276C99.4158 133.263 99.3423 133.267 99.2627 133.259V133.254L84.4295 127.438Z"
                                    fill="#8D939F" />
                                <path
                                    d="M141.337 136.307C142.559 142.679 143.73 149.064 145.155 155.393C145.55 157.145 146.569 158.845 147.636 160.31C149.034 162.226 150.706 163.943 152.363 165.639C154.937 168.273 156.872 171.273 157.82 174.919C157.919 175.299 158.073 175.662 158.302 176.324C159.688 174.535 160.165 172.725 160.297 170.86L161.104 162.124C161.255 161.158 161.437 160.196 161.551 159.225C162.321 152.629 162.423 146.013 162.027 139.392C161.813 135.817 161.526 132.247 161.202 128.686C161.06 127.12 160.58 126.812 159.218 127.339L144.176 133.235C143.948 133.243 143.711 133.269 143.46 133.311C141.881 133.56 141.024 134.669 141.337 136.307Z"
                                    fill="#8D939F" />
                                <path
                                    d="M131.208 234.58C135.038 228.514 137.152 221.759 138.717 214.78C140.049 208.845 140.95 202.838 141.257 196.729C141.4 193.886 140.245 192.555 137.526 192.906C133.398 193.443 129.504 194.837 125.615 196.286C124.291 196.784 123.568 197.688 123.374 199.087C123.025 201.562 122.523 204.033 122.404 206.521C122.077 213.352 121.841 227.031 121.917 227.035C121.917 231.167 121.912 235.302 121.92 239.434C121.921 240.976 122.088 241.081 123.538 240.629C126.822 239.607 129.317 237.575 131.208 234.58Z"
                                    fill="#8D939F" />
                                <path
                                    d="M119.773 199.581C119.605 197.811 118.748 196.652 117.06 196.181C116.29 195.969 115.57 195.553 114.799 195.345C111.667 194.509 108.546 193.605 105.379 192.952C103.071 192.476 101.619 193.928 101.75 196.194C102.215 204.215 103.418 212.109 105.572 219.824C107.252 225.847 109.415 231.639 113.177 236.647C115.156 239.283 117.879 240.361 120.982 241.277C121.036 240.233 121.112 239.486 121.108 238.739C121.066 229.933 121.129 221.127 120.911 212.33C120.807 208.073 120.176 203.829 119.773 199.581Z"
                                    fill="#8D939F" />
                                <path
                                    d="M132.669 234.73C132.478 235.085 132.485 235.555 132.398 235.974C132.821 235.974 133.301 236.109 133.654 235.949C134.906 235.377 136.22 234.857 137.32 234.045C145.606 227.93 151.999 220.114 156.598 210.746C158.157 207.572 159.553 204.284 159.763 200.679C160.123 194.484 159.084 188.446 157.489 182.501C157.358 182.01 157.078 181.561 156.715 180.753C156.247 181.646 155.982 182.153 155.715 182.661C153.533 186.812 150.73 190.473 146.702 192.749C144.377 194.061 143.473 195.681 143.488 198.305C143.516 203.776 142.428 209.087 140.972 214.326C138.986 221.464 136.139 228.23 132.669 234.73Z"
                                    fill="#8D939F" />
                                <path
                                    d="M102.627 231.671C104.706 233.451 106.808 235.243 109.494 235.996C109.832 236.093 110.236 235.937 110.608 235.894C110.541 235.544 110.544 235.159 110.396 234.85C109.288 232.58 108.064 230.364 107.038 228.056C102.686 218.277 99.5132 208.168 99.4413 197.252C99.4303 195.429 98.7472 194.144 97.1768 193.32C92.8838 191.054 89.9652 187.38 87.5332 183.211C87.1467 182.547 86.826 181.845 86.4767 181.156C86.3345 181.156 86.1923 181.156 86.0506 181.156C85.8304 181.761 85.5301 182.344 85.4059 182.97C84.7514 186.276 84.0046 189.574 83.5499 192.914C82.9081 197.624 82.9481 202.304 84.7449 206.836C88.6595 216.704 94.7223 224.898 102.627 231.671Z"
                                    fill="#8D939F" />
                                <path
                                    d="M122.385 191.657C122.406 193.982 123.714 194.901 125.86 194.295C129.386 193.296 132.921 192.305 136.488 191.477C137.984 191.13 139.102 190.444 139.862 189.14C142.088 185.322 143.349 181.183 143.687 176.747C143.762 175.76 143.381 175.146 142.594 174.602C137.909 171.362 132.71 170.061 127.131 170.295C123.596 170.442 123.148 170.191 122.382 174.815C122.322 175.179 122.317 175.555 122.315 175.927C122.311 178.486 122.313 181.045 122.313 183.604C122.336 183.604 122.358 183.604 122.381 183.604C122.381 186.288 122.363 188.973 122.385 191.657Z"
                                    fill="#8D939F" />
                                <path
                                    d="M106.184 191.334C109.912 192.267 113.62 193.284 117.318 194.335C119.138 194.852 120.37 193.931 120.406 191.947C120.498 187.139 120.713 182.33 120.686 177.521C120.677 175.605 120.214 173.675 119.849 171.771C119.656 170.766 118.894 170.254 117.895 170.27C115.431 170.304 112.946 170.174 110.507 170.455C106.89 170.876 103.569 172.284 100.527 174.39C99.6279 175.012 99.1502 175.752 99.3496 176.899C99.8261 181.267 100.975 185.415 103.243 189.182C103.929 190.321 104.875 191.01 106.184 191.334Z"
                                    fill="#8D939F" />
                                <path
                                    d="M122.343 166.107C122.366 167.86 122.653 168.141 124.372 168.183C126.524 168.243 128.679 168.255 130.833 168.238C135.067 168.204 138.913 169.465 142.463 171.809C142.839 172.056 143.319 172.132 143.751 172.289C143.874 171.818 144.143 171.33 144.094 170.879C143.697 167.389 143.324 163.895 142.745 160.438C142.586 159.487 141.908 158.494 141.207 157.801C137.29 153.925 132.522 152.048 127.146 151.712C126.456 151.746 125.763 151.755 125.077 151.831C123.161 152.031 122.716 152.472 122.409 154.43C122.351 154.804 122.316 155.181 122.316 155.559C122.316 159.075 122.298 162.591 122.343 166.107Z"
                                    fill="#8D939F" />
                                <path
                                    d="M120.602 153.601C120.431 152.55 119.835 152.044 118.779 151.899C112.713 151.065 107.471 153.086 102.757 156.801C101.853 157.511 100.955 158.537 100.59 159.613C99.3328 163.324 98.7835 167.196 98.9291 171.144C98.9441 171.527 99.1755 171.906 99.307 172.289C99.6684 172.153 100.073 172.089 100.381 171.881C102.935 170.128 105.684 168.855 108.754 168.502C110.785 168.272 112.836 168.226 114.877 168.094C114.88 168.115 114.881 168.136 114.883 168.153C116.359 168.153 117.834 168.158 119.308 168.153C120.117 168.149 120.621 167.8 120.712 166.915C121.162 162.473 121.324 158.03 120.602 153.601Z"
                                    fill="#8D939F" />
                                <path
                                    d="M122.34 139.084C122.312 141.751 122.308 144.421 122.316 147.087C122.319 148.101 122.853 148.731 123.788 148.955C124.373 149.098 124.978 149.17 125.578 149.229C131.06 149.783 136.262 151.266 141.037 154.181C141.375 154.388 141.734 154.558 142.446 154.934C142.446 154.029 142.546 153.45 142.43 152.922C141.413 148.296 140.377 143.677 139.305 139.063C138.828 137.01 137.687 135.4 135.818 134.517C133.409 133.38 130.94 132.375 128.497 131.31C127.573 130.908 126.804 131.191 126.277 132.007C125.026 133.946 123.812 135.907 122.623 137.889C122.422 138.218 122.345 138.683 122.34 139.084Z"
                                    fill="#8D939F" />
                                <path
                                    d="M120.39 137.949C119.19 135.886 117.903 133.878 116.601 131.887C116.123 131.156 115.395 130.959 114.562 131.278C112.785 131.954 110.981 132.568 109.228 133.311C106.054 134.651 103.887 136.861 103.186 140.499C102.433 144.398 101.428 148.25 100.596 152.137C100.439 152.868 100.573 153.662 100.573 154.531C100.912 154.493 101.043 154.51 101.144 154.46C101.436 154.321 101.721 154.161 101.999 153.993C105.517 151.889 109.258 150.401 113.295 149.75C115.127 149.456 116.973 149.221 118.798 148.872C120.307 148.582 120.679 148.049 120.684 146.49C120.69 144.247 120.705 142.003 120.674 139.764C120.664 139.151 120.676 138.437 120.39 137.949Z"
                                    fill="#8D939F" />
                                <path
                                    d="M142.17 192.782C143.764 192.137 145.489 191.648 146.866 190.652C150.943 187.704 153.551 183.494 155.327 178.765C156.165 176.534 155.857 174.239 154.521 172.197C152.224 168.688 149.373 165.71 146.235 163.019C145.891 162.723 145.436 162.567 144.759 162.196C144.891 162.943 144.942 163.381 145.047 163.803C146.282 168.76 146.904 173.788 146.543 178.904C146.199 183.819 144.786 188.298 141.212 191.795C141.017 191.985 140.88 192.238 140.461 192.803C141.266 192.803 141.774 192.942 142.17 192.782Z"
                                    fill="#8D939F" />
                                <path
                                    d="M102.077 191.881C98.8335 188.889 97.2887 185.019 96.7263 180.694C95.9813 174.954 96.627 169.312 98.0484 163.741C98.162 163.298 98.1956 162.829 98.2678 162.373C98.1747 162.314 98.082 162.259 97.9873 162.196C97.5069 162.529 96.949 162.787 96.5564 163.209C93.9541 165.994 91.2656 168.708 88.849 171.654C86.9198 174.009 86.7258 176.878 88.0208 179.643C89.0348 181.808 90.2097 183.93 91.5667 185.884C93.5939 188.801 96.0982 191.236 99.5017 192.417C100.421 192.738 101.401 193.181 102.527 192.506C102.314 192.206 102.221 192.016 102.077 191.881Z"
                                    fill="#8D939F" />
                            </g>
                            <g class="lower-extremity js-body-area" data-body-part="lower-extremity">
                                <path
                                    d="M84.2973 448.762C84.1926 448.521 83.7838 448.215 83.5919 448.262C83.3623 448.321 83.0865 448.715 83.0516 448.991C82.7981 451.097 82.4878 453.203 82.4181 455.317L80.3551 468.185L77.1277 471.655C73.5579 476.54 70.4428 479.667 65.4091 482.917C64.8721 483.264 61.3039 486.404 58.9733 489.472C57.1099 491.921 56.0375 494.328 57.9325 495.222C66.3534 499.12 73.179 501.619 81.0824 494.963C83.0946 493.264 84.7215 491.662 87.1917 490.645C89.681 489.62 93.2061 488.959 93.9683 485.786C94.0555 485.421 95.4516 479.612 95.4516 479.612L95.4658 479.443C95.5988 479.006 95.7286 478.57 95.7635 478.125C96.0267 474.837 96.234 471.541 96.4559 468.248C96.6222 465.778 95.8126 463.787 94.1792 461.927C90.5668 457.812 86.55 454.003 84.2973 448.762Z"
                                    fill="#8D939F" />
                                <path
                                    d="M100.191 376.244C100.145 375.987 99.9988 368.084 99.7809 367.51C99.5692 368.155 98.375 372.668 98.2984 373.009C97.9979 374.346 97.7182 375.687 97.4287 377.024C95.8872 384.134 94.3126 391.235 92.8191 398.354C92.0256 402.136 91.0968 405.919 90.7246 409.757C90.1359 415.838 89.8244 421.961 89.6526 428.075C89.4742 434.422 90.0838 440.718 91.776 446.866C92.5646 449.734 93.322 452.61 94.0932 455.482C93.8786 455.419 93.7943 455.296 93.7467 455.161C93.0785 453.243 92.3435 451.345 91.7617 449.401C88.9274 439.913 88.089 430.108 87.9954 420.27C87.8919 409.394 87.3655 398.552 86.6081 387.71C86.2551 382.654 86.0499 377.576 86.012 372.503C85.9672 366.54 86.7372 360.632 87.7136 354.758C88.0446 352.772 88.2975 350.769 88.6122 348.597C88.2849 348.728 88.1814 348.732 88.1432 348.787C87.7612 349.322 87.3875 349.862 87.0169 350.402C80.3593 360.101 76.4895 371.032 75.1056 382.843C74.1752 390.788 73.8889 401.322 75.1056 409.25C76.8507 420.628 77.2896 426.228 80.8251 437.163C82.1533 441.275 85.6126 448.195 88.2718 451.649C90.7788 454.904 93.2837 458.16 95.8 461.411C96.1099 461.812 96.4869 462.157 97.0659 462.777C97.1803 462.022 97.3538 461.584 97.2903 461.188C96.6653 457.337 96.3676 453.369 95.2512 449.675C93.9213 445.281 93.7593 438.9 94.6404 434.38C96.8399 423.078 100.155 418.406 102.453 407.121C103.468 402.145 103.727 395.246 102.658 390.084C101.65 385.205 101.068 381.152 100.191 376.244Z"
                                    fill="#8D939F" />
                                <path
                                    d="M95.0573 337.277C94.4643 338.417 93.8395 339.573 93.4671 340.797C92.1606 345.104 90.8463 349.41 89.7361 353.772C88.3863 359.079 87.4971 364.482 87.6208 370C87.7549 375.929 87.8596 381.862 88.1174 387.787C88.3331 392.754 88.7438 397.713 89.0935 402.672C89.1307 403.21 89.327 403.735 89.4494 404.269C89.5653 404.269 89.6829 404.273 89.7992 404.277C89.9584 403.748 90.1584 403.223 90.271 402.685C91.8064 395.414 93.2902 388.13 94.8722 380.871C95.671 377.212 96.6505 373.591 97.5334 369.949C98.0246 367.929 98.6577 365.922 98.9282 363.868C99.6677 358.278 99.2008 352.675 98.6399 347.111C98.3162 343.884 97.5396 340.708 96.9016 337.523C96.8196 337.117 96.3911 336.621 96.0207 336.502C95.7918 336.43 95.2442 336.922 95.0573 337.277Z"
                                    fill="#8D939F" />
                                <path
                                    d="M104.164 292.562C104.095 292.957 103.998 293.351 103.965 293.751C103.608 298.008 103.304 302.274 102.896 306.528C102.587 309.733 102.324 312.963 101.726 316.121C100.674 321.665 99.3695 327.162 98.2038 332.685C98.0874 333.237 98.054 333.882 98.2168 334.409C100.608 342.139 101.016 350.106 100.961 358.138C100.95 359.653 100.871 361.169 100.823 362.688C100.934 362.701 101.045 362.714 101.155 362.727C105.586 351.953 107.922 340.67 108.455 328.967C109.017 316.605 107.927 304.431 104.658 292.524C104.494 292.537 104.328 292.549 104.164 292.562Z"
                                    fill="#8D939F" />
                                <path
                                    d="M101.309 292.518C101.395 287.279 101.239 282.019 100.109 276.911C98.3524 268.965 96.2294 261.108 94.3522 253.188C91.8322 242.548 89.4017 231.884 86.9218 221.231C86.619 219.935 86.2763 218.644 85.8809 217.373C85.7916 217.089 85.4011 216.903 85.1493 216.67C84.9755 216.971 84.754 217.254 84.6409 217.576C84.5471 217.843 84.5597 218.157 84.5597 218.449C84.5565 221.752 84.6169 225.056 84.5483 228.355C84.4622 232.413 84.3969 236.475 84.0881 240.515C83.7564 244.844 83.0791 249.147 82.6853 253.476C81.9187 261.934 81.1459 270.392 80.5673 278.863C80.1797 284.535 79.8259 290.235 79.9838 295.907C80.2641 305.894 80.9737 315.868 81.4519 325.851C81.6938 330.904 81.8726 335.961 81.9872 341.019C82.0827 345.195 82.0431 349.371 82.0639 353.848C82.4287 353.437 82.6678 353.225 82.8383 352.967C85.5047 348.884 88.2621 344.86 90.7947 340.692C93.1824 336.762 95.342 332.675 96.6868 328.215C99.1847 319.939 100.028 311.353 100.89 302.789C101.231 299.384 101.253 295.945 101.309 292.518Z"
                                    fill="#8D939F" />
                                <path
                                    d="M115.414 243.769C113.069 241.787 106.912 238.83 104.671 236.726C98.7037 231.123 95.7298 229.365 91.3192 222.339C90.314 220.738 89.3661 219.098 88.3912 217.476C88.2635 217.501 88.1355 217.522 88.0078 217.548C88.0892 218.35 88.1355 219.157 88.2602 219.952C89.4606 227.549 91.4067 234.951 93.6732 242.277C98.8747 259.106 103.071 276.218 106.894 293.427C107.541 296.343 108.107 299.279 108.709 302.203C109.04 301.899 109.165 301.574 109.22 301.236C109.721 298.109 111.484 291.928 111.901 288.788C114.175 277.908 114.297 276.13 115.414 267.024C116.447 258.063 116.654 256.504 116.654 251.45C116.654 246.756 116.708 244.863 115.414 243.769Z"
                                    fill="#8D939F" />
                                <path
                                    d="M72.1696 298.842C72.1937 299.138 79.9143 330.158 79.9922 330.445C80.2424 328.462 77.9749 298.36 78.1391 289.447C78.3666 277.002 79.8507 266.423 80.9415 254.029C81.1323 251.869 81.4412 249.716 81.6308 247.556C82.0417 242.858 82.6449 238.156 82.7358 233.45C82.8536 227.403 82.5687 221.348 82.4093 215.293C82.3506 213.06 82.1546 210.827 82.0225 208.599C81.8872 208.599 81.7518 208.603 81.6181 208.608C81.5382 208.916 81.4494 209.225 81.3809 209.538C80.6627 212.794 80.0912 216.092 79.2075 219.301C76.1822 230.282 72.4851 243.133 71.5517 254.427C70.9341 261.903 69.1475 270.867 69.4932 277.489C69.9024 285.324 70.9341 290.089 72.1696 298.842Z"
                                    fill="#8D939F" />
                                <path
                                    d="M148.35 337.277C148.165 336.922 147.617 336.43 147.387 336.502C147.018 336.621 146.588 337.117 146.508 337.523C145.868 340.708 145.091 343.884 144.768 347.111C144.207 352.675 143.74 358.278 144.479 363.868C144.75 365.922 145.385 367.929 145.874 369.949C146.759 373.591 147.738 377.212 148.536 380.871C150.117 388.13 151.601 395.414 153.137 402.685C153.251 403.223 153.449 403.748 153.608 404.277C153.726 404.273 153.842 404.269 153.96 404.269C154.082 403.735 154.277 403.21 154.316 402.672C154.664 397.713 155.076 392.754 155.292 387.787C155.55 381.862 155.653 375.929 155.787 370C155.91 364.482 155.021 359.079 153.672 353.772C152.561 349.41 151.247 345.104 149.94 340.797C149.568 339.573 148.943 338.417 148.35 337.277Z"
                                    fill="#8D939F" />
                                <path
                                    d="M161.339 353.848C161.36 349.371 161.322 345.195 161.417 341.019C161.532 335.961 161.71 330.904 161.952 325.851C162.429 315.868 163.14 305.894 163.419 295.907C163.578 290.235 163.223 284.535 162.835 278.863C162.257 270.392 161.486 261.934 160.717 253.476C160.325 249.147 159.646 244.844 159.315 240.515C159.007 236.475 158.94 232.413 158.856 228.355C158.786 225.056 158.846 221.752 158.843 218.449C158.843 218.157 158.856 217.843 158.763 217.576C158.649 217.254 158.429 216.971 158.253 216.67C158.001 216.903 157.611 217.089 157.522 217.373C157.126 218.644 156.783 219.935 156.481 221.231C154.001 231.884 151.572 242.548 149.05 253.188C147.174 261.108 145.05 268.965 143.293 276.911C142.163 282.019 142.008 287.279 142.094 292.518C142.15 295.945 142.171 299.384 142.514 302.789C143.374 311.353 144.219 319.939 146.715 328.215C148.061 332.675 150.221 336.762 152.608 340.692C155.142 344.86 157.898 348.884 160.566 352.967C160.735 353.225 160.976 353.437 161.339 353.848Z"
                                    fill="#8D939F" />
                                <path
                                    d="M142.598 362.688C142.55 361.169 142.47 359.653 142.461 358.138C142.403 350.106 142.813 342.139 145.203 334.409C145.366 333.882 145.332 333.237 145.216 332.685C144.05 327.162 142.748 321.665 141.695 316.121C141.096 312.963 140.833 309.733 140.525 306.528C140.115 302.274 139.813 298.008 139.455 293.751C139.422 293.351 139.324 292.957 139.256 292.562C139.092 292.549 138.926 292.537 138.761 292.524C135.493 304.431 134.403 316.605 134.965 328.967C135.498 340.67 137.835 351.953 142.264 362.727C142.376 362.714 142.486 362.701 142.598 362.688Z"
                                    fill="#8D939F" />
                                <path
                                    d="M147.604 461.411C150.12 458.16 152.625 454.904 155.132 451.649C157.791 448.195 161.25 441.275 162.58 437.163C166.114 426.228 166.553 420.628 168.3 409.25C169.516 401.322 169.23 390.788 168.3 382.843C166.914 371.032 163.044 360.101 156.387 350.402C156.016 349.862 155.644 349.322 155.262 348.787C155.222 348.732 155.119 348.728 154.792 348.597C155.106 350.769 155.359 352.772 155.69 354.758C156.667 360.632 157.437 366.54 157.392 372.503C157.354 377.576 157.149 382.654 156.796 387.71C156.04 398.552 155.512 409.394 155.41 420.27C155.317 430.108 154.478 439.913 151.642 449.401C151.06 451.345 150.327 453.243 149.657 455.161C149.611 455.296 149.526 455.419 149.311 455.482C150.082 452.61 150.839 449.734 151.63 446.866C153.322 440.718 153.93 434.422 153.751 428.075C153.58 421.961 153.27 415.838 152.679 409.757C152.309 405.919 151.378 402.136 150.587 398.354C149.093 391.235 147.517 384.134 145.977 377.024C145.686 375.687 145.406 374.346 145.106 373.009C145.029 372.668 143.835 368.155 143.625 367.51C143.406 368.084 143.259 375.987 143.213 376.244C142.337 381.152 141.754 385.205 140.746 390.084C139.679 395.246 139.937 402.145 140.952 407.121C143.25 418.406 146.564 423.078 148.765 434.38C149.645 438.9 149.483 445.281 148.155 449.675C147.037 453.369 146.741 457.337 146.116 461.188C146.05 461.584 146.225 462.022 146.34 462.777C146.919 462.157 147.294 461.812 147.604 461.411Z"
                                    fill="#8D939F" />
                                <path
                                    d="M171.24 298.842C172.474 290.089 173.506 285.324 173.915 277.489C174.261 270.867 172.474 261.903 171.856 254.427C170.923 243.133 167.227 230.282 164.202 219.301C163.318 216.092 162.745 212.794 162.027 209.538C161.958 209.225 161.871 208.916 161.791 208.608C161.656 208.603 161.52 208.599 161.387 208.599C161.253 210.827 161.057 213.06 160.998 215.293C160.839 221.348 160.556 227.403 160.672 233.45C160.764 238.156 161.368 242.858 161.778 247.556C161.966 249.716 162.277 251.869 162.466 254.029C163.559 266.423 165.041 277.002 165.269 289.447C165.433 298.36 163.165 328.462 163.417 330.445C163.493 330.158 171.214 299.138 171.24 298.842Z"
                                    fill="#8D939F" />
                                <path
                                    d="M136.908 293.427C140.732 276.218 144.928 259.106 150.129 242.277C152.396 234.951 154.342 227.549 155.541 219.952C155.667 219.157 155.712 218.35 155.795 217.548C155.667 217.522 155.537 217.501 155.41 217.476C154.435 219.098 153.487 220.738 152.482 222.339C148.071 229.365 145.098 231.123 139.132 236.726C136.89 238.83 130.733 241.787 128.389 243.769C127.094 244.863 127.149 246.756 127.149 251.45C127.149 256.504 127.356 258.063 128.389 267.024C129.506 276.13 129.629 277.908 131.901 288.788C132.318 291.928 134.082 298.109 134.583 301.236C134.637 301.574 134.762 301.899 135.093 302.203C135.695 299.279 136.26 296.343 136.908 293.427Z"
                                    fill="#8D939F" />
                                <path
                                    d="M178.294 482.917C173.209 479.667 170.063 476.54 166.458 471.655L163.196 468.185L161.112 455.317C161.042 453.203 160.728 451.097 160.472 448.991C160.439 448.715 160.158 448.321 159.926 448.262C159.734 448.215 159.32 448.521 159.214 448.762C156.94 454.003 152.88 457.812 149.233 461.927C147.581 463.787 146.765 465.778 146.931 468.248C147.156 471.541 147.365 474.837 147.631 478.125C147.668 478.57 147.799 479.006 147.933 479.443L147.948 479.612C147.948 479.612 149.356 485.421 149.444 485.786C150.216 488.959 153.777 489.62 156.29 490.645C158.785 491.662 160.429 493.264 162.463 494.963C170.445 501.619 177.34 499.12 185.849 495.222C187.763 494.328 186.678 491.921 184.796 489.472C182.441 486.404 178.837 483.264 178.294 482.917Z"
                                    fill="#8D939F" />
                            </g>
                            <g class="shoulders js-body-area" data-body-part="upper-extremity">
                                <path
                                    d="M56.7615 123.578C58.4328 122.435 61.0712 121.237 62.8439 120.302C64.9154 119.21 70.7595 118.237 72.8835 117.247C77.0054 115.326 77.1961 116.605 79.66 112.097C82.9084 106.156 87.3101 98.6522 88.7448 92.0531C88.9957 90.9016 88.6793 89.9073 87.855 89.219C86.3874 87.9994 84.875 86.818 83.2691 85.8152C82.6783 85.4498 81.7153 85.5136 81.0134 85.6283C74.526 86.6693 70.6912 87.5405 65.7986 91.3902C62.817 93.7316 58.4153 98.8945 57.0697 102.549C54.6013 109.254 55.1795 117.192 54.938 124.309C54.9299 124.496 55.0238 124.691 55.119 125.078C55.5207 124.708 56.4455 123.795 56.7615 123.578Z"
                                    fill="#8D939F" />
                                <path
                                    d="M154.267 92.0531C155.702 98.6522 160.102 106.156 163.352 112.097C165.816 116.605 166.005 115.326 170.129 117.247C172.253 118.237 178.097 119.21 180.168 120.302C181.941 121.237 184.58 122.435 186.251 123.578C186.567 123.795 187.491 124.708 187.893 125.078C187.989 124.691 188.081 124.496 188.074 124.309C187.833 117.192 188.41 109.254 185.943 102.549C184.597 98.8945 180.195 93.7316 177.214 91.3902C172.321 87.5405 168.486 86.6693 161.999 85.6283C161.296 85.5136 160.334 85.4498 159.743 85.8152C158.137 86.818 156.625 87.9994 155.157 89.219C154.331 89.9073 154.018 90.9016 154.267 92.0531Z"
                                    fill="#8D939F" />
                            </g>



                        </g>

                    </svg>
                </div>
                <div class="human-body-areas_area human-body-areas-back">
                    <h3 class="human-body-areas_area-title">Back</h3>

                    <svg width="160" height="500" viewBox="0 0 160 500" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="human-body-areas_female js-human-body-svg">
                        <g class="nerv-system js-body-area" data-body-part="nerv-system">
                            <path
                                d="M158.747 275.35C158.747 277.996 156.964 287.265 155.213 289.536C153.609 291.621 146.676 295.868 145.544 295.868C144.404 295.868 143.836 294.737 143.836 294.737C143.836 294.737 141.879 295.408 141.565 294.025C141.136 292.166 143.416 291.033 144.269 290.323C145.119 289.614 147.259 288.442 148.399 286.17C149.531 283.898 149.241 275.163 147.954 274.926C145.913 274.546 146.044 278.1 145.901 279.805C145.758 281.51 146.04 285.455 144.17 285.515C140.31 285.636 141.418 278.474 141.418 276.202C141.418 273.931 140.072 271.086 139.858 269.101C139.433 265.129 142.701 260.866 142.701 257.461C142.701 256.636 140.846 250.722 139.635 246.068C136.268 232.024 124.177 190.618 124.177 183.902C124.177 181.283 123.899 177.807 123.569 174.341C123.521 173.884 123.474 173.428 123.43 172.972C123.378 172.509 123.335 172.042 123.291 171.585C123.236 171.096 123.188 170.617 123.136 170.144C123.085 169.638 123.033 169.143 122.985 168.664C122.93 168.142 122.878 167.636 122.83 167.146C122.775 166.596 122.727 166.068 122.676 165.567C122.676 165.54 122.672 165.518 122.672 165.49C122.636 165.138 122.584 164.604 122.513 163.922C122.461 163.422 122.394 162.838 122.33 162.184C122.263 161.618 122.199 161.002 122.128 160.336C122.06 159.725 121.985 159.07 121.913 158.383C121.834 157.701 121.75 156.986 121.671 156.243C121.588 155.5 121.5 154.736 121.409 153.944V153.938C121.314 153.102 121.218 152.238 121.119 151.369V151.363C121.008 150.406 120.893 149.428 120.778 148.443C120.778 148.437 120.778 148.437 120.778 148.437C120.651 147.304 120.519 146.16 120.388 145.021V145.016C120.218 143.574 120.047 142.131 119.888 140.738C119.88 140.738 119.88 140.73 119.888 140.726C119.634 138.585 119.388 136.533 119.161 134.67C119.157 134.67 119.161 134.662 119.161 134.662C119.106 134.233 119.058 133.816 119.006 133.407C118.879 134.102 118.605 135.107 118.288 136.29C118.101 136.985 117.895 137.736 117.692 138.526C117.688 138.53 117.692 138.53 117.692 138.53C117.509 139.241 117.331 139.971 117.16 140.71C116.997 141.433 116.85 142.167 116.723 142.882C116.687 143.136 116.64 143.386 116.608 143.64C116.549 144.053 116.489 144.543 116.421 145.114C116.421 145.12 116.421 145.12 116.421 145.12C116.35 145.764 116.275 146.501 116.195 147.304C116.132 147.953 116.064 148.651 115.997 149.378C115.937 150.005 115.881 150.66 115.822 151.325C115.774 151.936 115.719 152.563 115.667 153.19C115.611 153.779 115.564 154.367 115.52 154.961C115.468 155.528 115.425 156.095 115.377 156.656C115.337 157.206 115.294 157.756 115.25 158.295C115.206 158.828 115.163 159.351 115.123 159.857C115.083 160.38 115.04 160.891 115.004 161.381C114.964 161.893 114.921 162.387 114.881 162.855C114.841 163.367 114.805 163.845 114.766 164.285C114.726 164.808 114.69 165.281 114.654 165.688C114.627 165.996 114.607 166.271 114.583 166.508C114.071 172.13 112.034 177.488 113.082 185.123C113.809 190.431 117.355 195.157 119.102 198.865C122.862 206.852 125.618 217.815 126.654 224.125C128.572 235.925 129.112 241.155 129.795 245.243C130.474 249.33 134.1 264.678 133.933 274.558C133.762 284.432 120.817 344.885 120.646 347.267C120.476 349.65 121.159 354.59 120.988 357.655C120.817 360.725 119.63 366.34 119.63 369.234C119.63 372.133 123.835 386.262 123.887 393.588C123.891 395.216 123.875 396.844 123.835 398.468C123.748 402.471 123.541 406.465 123.263 410.46C122.977 414.709 122.612 418.958 122.203 423.203C121.794 427.428 121.341 431.653 120.849 435.874C120.392 439.801 119.908 443.724 119.408 447.644C118.975 450.995 118.53 454.346 118.077 457.694C117.736 460.199 117.394 462.697 117.061 465.199C116.807 467.113 116.564 468.939 116.636 470.857C116.66 471.425 116.68 471.997 116.703 472.565C116.739 473.708 116.783 474.852 116.791 475.996C116.819 482.575 119.574 483.588 123.116 485.867C126.44 488.004 130.351 490.438 136.24 491.693C138.448 492.165 140.39 496.061 135.652 496.66C133.191 496.966 113.296 498.578 107.539 498.578C104.93 498.578 101.844 497.963 100.844 495.695C99.7477 493.233 99.8629 489.739 100.645 485.228C101.284 481.551 100.693 479.423 100.657 477.262C100.586 473.498 101.769 469.912 101.332 466.124C101.106 464.182 100.828 462.248 100.55 460.319C99.6882 454.307 98.751 448.299 97.8338 442.291C96.7934 435.465 95.753 428.639 94.7762 421.801C94.0376 416.607 93.2673 411.405 92.8225 406.172C92.7272 405.107 92.6319 404.027 92.6676 402.955C92.9416 395.291 94.8119 391.205 94.6411 386.095C94.4744 380.984 89.7093 369.405 88.8556 358.68C88.0019 347.95 90.8966 345.226 90.5551 339.949C90.2215 334.668 83.745 284.091 83.4035 278.134C83.1137 272.99 83.6458 271.098 83.4711 268.49C82.1845 268.727 81.3268 268.996 79.8576 269.034C78.9363 269.056 77.4988 268.82 76.5895 268.605C76.5339 271.059 76.8794 273.578 76.6213 278.134C76.2798 284.091 69.8072 334.668 69.4657 339.949C69.1282 345.226 72.023 347.95 71.1692 358.68C70.3195 369.405 65.5505 380.984 65.3837 386.095C65.2129 391.205 67.0832 395.291 67.3572 402.955C67.4088 404.297 67.2579 405.655 67.1388 406.986C66.6305 412.378 65.8562 417.743 65.0977 423.1C64.1368 429.906 63.1123 436.704 62.0879 443.502C61.2143 449.323 60.3168 455.149 59.5027 460.978C59.2565 462.773 58.9985 464.567 58.8119 466.366C58.7007 467.415 58.6014 468.372 58.6014 469.428C58.6014 472.037 59.471 474.65 59.4274 477.262C59.3876 479.423 58.792 481.551 59.4353 485.228C60.2175 489.739 60.3287 493.233 59.2407 495.695C58.2321 497.963 55.1467 498.578 52.5379 498.578C46.7841 498.578 26.8939 496.966 24.4279 496.66C19.6867 496.061 21.6285 492.165 23.8363 491.693C29.733 490.438 33.6443 488.004 36.964 485.867C40.51 483.588 43.2658 482.575 43.2936 475.996C43.3016 473.085 43.6073 470.222 43.242 467.327C42.9839 465.258 42.698 463.198 42.4161 461.137C42.011 458.131 41.5981 455.121 41.201 452.107C40.7165 448.422 40.244 444.737 39.7913 441.044C39.291 436.95 38.8184 432.852 38.3856 428.754C37.9409 424.521 37.5319 420.276 37.1784 416.035C36.8449 411.925 36.559 407.82 36.3723 403.698C36.2175 400.33 36.1182 396.959 36.1421 393.588C36.1897 386.262 40.3988 372.133 40.3988 369.234C40.3988 366.34 39.2116 360.725 39.0408 357.655C38.8701 354.59 39.553 349.65 39.3823 347.267C39.2115 344.885 26.2665 284.432 26.0957 274.558C25.925 264.678 29.5504 249.33 30.2333 245.243C30.9163 241.155 31.4524 235.925 33.3743 224.125C34.4028 217.815 37.1626 206.852 40.927 198.865C42.6702 195.157 46.2202 190.431 46.9429 185.123C47.9952 177.488 45.9541 172.63 45.4418 167.008C45.0964 163.191 43.7304 145.56 43.4644 143.64C43.1944 141.726 42.702 139.225 41.8165 135.687C40.514 146.352 37.655 162.283 37.3571 165.49C36.8767 170.677 35.8482 178.879 35.8482 183.902C35.8482 190.635 23.1652 232.811 19.8376 246.745C18.3565 252.35 17.3439 256.443 17.3439 257.367C17.3439 260.783 20.6159 265.057 20.195 269.04C19.9806 271.026 18.6265 273.881 18.6265 276.158C18.6265 278.435 19.6827 286.038 15.831 285.658C13.7463 285.455 13.9289 281.654 14.0203 279.943C14.1592 277.462 14.1195 274.497 12.0785 274.877C10.7879 275.113 10.4901 283.871 11.6337 286.148C12.7654 288.425 14.9216 289.597 15.7754 290.312C16.6291 291.022 18.9123 292.155 18.4835 294.02C18.1618 295.408 16.2042 294.729 16.2042 294.729C16.2042 294.729 15.6324 295.868 14.4927 295.868C13.3571 295.868 6.40802 291.61 4.79981 289.526C3.04865 287.242 1.25781 277.952 1.25781 275.305C1.25781 274.464 3.22734 270.063 4.64098 265.981C5.6337 263.11 6.14993 260.266 6.38421 259.501C6.95205 257.653 6.43183 257.087 6.76936 255.596C7.02349 254.512 7.11087 253.978 7.87725 252.449C8.05197 252.097 8.52451 246.854 8.73099 243.224C9.59665 234.769 10.7204 194.287 12.0864 186.911C13.5794 178.824 16.3591 172.724 17.4431 167.333C18.5192 161.936 17.7727 156.348 18.2532 144.966C18.4279 140.754 19.5676 131.779 18.968 123.992C18.3723 116.202 19.2181 99.6151 25.2618 91.3358C28.5537 86.8249 36.6781 85.2326 44.6874 83.1082C52.6927 80.9838 61.6987 78.0532 64.3116 73.6733C65.0263 72.4702 66.428 67.5185 66.7417 64.0201V64.0161C66.7536 63.897 66.7655 63.7898 66.7695 63.6786L93.2792 63.9685C93.2792 64.036 93.2792 64.0956 93.2831 64.1631C93.3348 67.9037 94.935 72.6925 95.5465 73.725C98.1594 78.1009 107.332 80.9838 115.337 83.1082C123.347 85.2326 131.471 86.8249 134.767 91.3358C140.807 99.6151 141.656 116.202 141.061 123.992C141.001 124.791 140.958 125.605 140.93 126.419C140.831 129.246 140.918 132.145 141.073 134.849V134.857C141.18 136.822 141.323 138.689 141.458 140.349V140.356C141.593 142.088 141.716 143.596 141.764 144.768V144.774C141.772 144.84 141.776 144.905 141.776 144.966C141.835 146.402 141.875 147.749 141.903 149.015C141.934 150.34 141.946 151.573 141.95 152.734V152.739C141.958 153.856 141.958 154.901 141.958 155.885C141.958 156.815 141.95 157.695 141.962 158.532V158.537C141.958 159.323 141.962 160.077 141.978 160.793C141.994 161.441 142.01 162.063 142.046 162.668C142.073 163.218 142.105 163.757 142.153 164.28V164.285C142.2 164.753 142.248 165.215 142.308 165.672C142.363 166.089 142.431 166.502 142.506 166.915C142.53 167.058 142.558 167.196 142.586 167.333C142.633 167.564 142.685 167.8 142.737 168.037C143.904 173.257 146.513 179.176 147.942 186.911C149.304 194.293 150.432 234.841 151.298 243.246C151.508 246.937 151.965 252.196 152.144 252.554C152.902 254.077 152.985 254.611 153.24 255.689C153.581 257.174 153.065 257.741 153.629 259.589C153.867 260.348 154.383 263.187 155.376 266.053C156.782 270.124 158.747 274.513 158.747 275.35Z"
                                fill="#F6F9FE" />
                            <path
                                d="M158.747 275.35C158.747 277.996 156.964 287.265 155.213 289.536C153.609 291.621 146.676 295.868 145.544 295.868C144.404 295.868 143.836 294.737 143.836 294.737C143.836 294.737 141.879 295.408 141.565 294.025C141.136 292.166 143.416 291.033 144.269 290.323C145.119 289.614 147.259 288.442 148.399 286.17C149.531 283.898 149.241 275.163 147.954 274.926C145.913 274.546 146.044 278.1 145.901 279.805C145.758 281.51 146.04 285.455 144.17 285.515C140.31 285.636 141.418 278.474 141.418 276.202C141.418 273.931 140.072 271.086 139.858 269.101C139.433 265.129 142.701 260.866 142.701 257.461C142.701 256.636 140.846 250.722 139.635 246.068C136.268 232.024 124.177 190.618 124.177 183.902C124.177 181.283 123.899 177.807 123.569 174.341C123.521 173.884 123.474 173.428 123.43 172.972C123.378 172.509 123.335 172.042 123.291 171.585C123.236 171.096 123.188 170.617 123.136 170.144C123.085 169.638 123.033 169.143 122.985 168.664C122.93 168.142 122.878 167.636 122.83 167.146C122.775 166.596 122.727 166.068 122.676 165.567C122.676 165.54 122.672 165.518 122.672 165.49C122.636 165.138 122.584 164.604 122.513 163.922C122.461 163.422 122.394 162.838 122.33 162.184C122.263 161.618 122.199 161.002 122.128 160.336C122.06 159.725 121.985 159.07 121.913 158.383C121.834 157.701 121.75 156.986 121.671 156.243C121.588 155.5 121.5 154.736 121.409 153.944V153.938C121.314 153.102 121.218 152.238 121.119 151.369V151.363C121.008 150.406 120.893 149.428 120.778 148.443C120.778 148.437 120.778 148.437 120.778 148.437C120.651 147.304 120.519 146.16 120.388 145.021V145.016C120.218 143.574 120.047 142.131 119.888 140.738C119.88 140.738 119.88 140.73 119.888 140.726C119.634 138.585 119.388 136.533 119.161 134.67C119.157 134.67 119.161 134.662 119.161 134.662C119.106 134.233 119.058 133.816 119.006 133.407C118.879 134.102 118.605 135.107 118.288 136.29C118.101 136.985 117.895 137.736 117.692 138.526C117.688 138.53 117.692 138.53 117.692 138.53C117.509 139.241 117.331 139.971 117.16 140.71C116.997 141.433 116.85 142.167 116.723 142.882C116.687 143.136 116.64 143.386 116.608 143.64C116.549 144.053 116.489 144.543 116.421 145.114C116.421 145.12 116.421 145.12 116.421 145.12C116.35 145.764 116.275 146.501 116.195 147.304C116.132 147.953 116.064 148.651 115.997 149.378C115.937 150.005 115.881 150.66 115.822 151.325C115.774 151.936 115.719 152.563 115.667 153.19C115.611 153.779 115.564 154.367 115.52 154.961C115.468 155.528 115.425 156.095 115.377 156.656C115.337 157.206 115.294 157.756 115.25 158.295C115.206 158.828 115.163 159.351 115.123 159.857C115.083 160.38 115.04 160.891 115.004 161.381C114.964 161.893 114.921 162.387 114.881 162.855C114.841 163.367 114.805 163.845 114.766 164.285C114.726 164.808 114.69 165.281 114.654 165.688C114.627 165.996 114.607 166.271 114.583 166.508C114.071 172.13 112.034 177.488 113.082 185.123C113.809 190.431 117.355 195.157 119.102 198.865C122.862 206.852 125.618 217.815 126.654 224.125C128.572 235.925 129.112 241.155 129.795 245.243C130.474 249.33 134.1 264.678 133.933 274.558C133.762 284.432 120.817 344.885 120.646 347.267C120.476 349.65 121.159 354.59 120.988 357.655C120.817 360.725 119.63 366.34 119.63 369.234C119.63 372.133 123.835 386.262 123.887 393.588C123.891 395.216 123.875 396.844 123.835 398.468C123.748 402.471 123.541 406.465 123.263 410.46C122.977 414.709 122.612 418.958 122.203 423.203C121.794 427.428 121.341 431.653 120.849 435.874C120.392 439.801 119.908 443.724 119.408 447.644C118.975 450.995 118.53 454.346 118.077 457.694C117.736 460.199 117.394 462.697 117.061 465.199C116.807 467.113 116.564 468.939 116.636 470.857C116.66 471.425 116.68 471.997 116.703 472.565C116.739 473.708 116.783 474.852 116.791 475.996C116.819 482.575 119.574 483.588 123.116 485.867C126.44 488.004 130.351 490.438 136.24 491.693C138.448 492.165 140.39 496.061 135.652 496.66C133.191 496.966 113.296 498.578 107.539 498.578C104.93 498.578 101.844 497.963 100.844 495.695C99.7477 493.233 99.8629 489.739 100.645 485.228C101.284 481.551 100.693 479.423 100.657 477.262C100.586 473.498 101.769 469.912 101.332 466.124C101.106 464.182 100.828 462.248 100.55 460.319C99.6882 454.307 98.751 448.299 97.8338 442.291C96.7934 435.465 95.753 428.639 94.7762 421.801C94.0376 416.607 93.2673 411.405 92.8225 406.172C92.7272 405.107 92.6319 404.027 92.6676 402.955C92.9416 395.291 94.8119 391.205 94.6411 386.095C94.4744 380.984 89.7093 369.405 88.8556 358.68C88.0019 347.95 90.8966 345.226 90.5551 339.949C90.2215 334.668 83.745 284.091 83.4035 278.134C83.1137 272.99 83.6458 271.098 83.4711 268.49C82.1845 268.727 81.3268 268.996 79.8576 269.034C78.9363 269.056 77.4988 268.82 76.5895 268.605C76.5339 271.059 76.8794 273.578 76.6213 278.134C76.2798 284.091 69.8072 334.668 69.4657 339.949C69.1282 345.226 72.023 347.95 71.1692 358.68C70.3195 369.405 65.5505 380.984 65.3837 386.095C65.2129 391.205 67.0832 395.291 67.3572 402.955C67.4088 404.297 67.2579 405.655 67.1388 406.986C66.6305 412.378 65.8562 417.743 65.0977 423.1C64.1368 429.906 63.1123 436.704 62.0879 443.502C61.2143 449.323 60.3168 455.149 59.5027 460.978C59.2565 462.773 58.9985 464.567 58.8119 466.366C58.7007 467.415 58.6014 468.372 58.6014 469.428C58.6014 472.037 59.471 474.65 59.4274 477.262C59.3876 479.423 58.792 481.551 59.4353 485.228C60.2175 489.739 60.3287 493.233 59.2407 495.695C58.2321 497.963 55.1467 498.578 52.5379 498.578C46.7841 498.578 26.8939 496.966 24.4279 496.66C19.6867 496.061 21.6285 492.165 23.8363 491.693C29.733 490.438 33.6443 488.004 36.964 485.867C40.51 483.588 43.2658 482.575 43.2936 475.996C43.3016 473.085 43.6073 470.222 43.242 467.327C42.9839 465.258 42.698 463.198 42.4161 461.137C42.011 458.131 41.5981 455.121 41.201 452.107C40.7165 448.422 40.244 444.737 39.7913 441.044C39.291 436.95 38.8184 432.852 38.3856 428.754C37.9409 424.521 37.5319 420.276 37.1784 416.035C36.8449 411.925 36.559 407.82 36.3723 403.698C36.2175 400.33 36.1182 396.959 36.1421 393.588C36.1897 386.262 40.3988 372.133 40.3988 369.234C40.3988 366.34 39.2116 360.725 39.0408 357.655C38.8701 354.59 39.553 349.65 39.3823 347.267C39.2115 344.885 26.2665 284.432 26.0957 274.558C25.925 264.678 29.5504 249.33 30.2333 245.243C30.9163 241.155 31.4524 235.925 33.3743 224.125C34.4028 217.815 37.1626 206.852 40.927 198.865C42.6702 195.157 46.2202 190.431 46.9429 185.123C47.9952 177.488 45.9541 172.63 45.4418 167.008C45.0964 163.191 43.7304 145.56 43.4644 143.64C43.1944 141.726 42.702 139.225 41.8165 135.687C40.514 146.352 37.655 162.283 37.3571 165.49C36.8767 170.677 35.8482 178.879 35.8482 183.902C35.8482 190.635 23.1652 232.811 19.8376 246.745C18.3565 252.35 17.3439 256.443 17.3439 257.367C17.3439 260.783 20.6159 265.057 20.195 269.04C19.9806 271.026 18.6265 273.881 18.6265 276.158C18.6265 278.435 19.6827 286.038 15.831 285.658C13.7463 285.455 13.9289 281.654 14.0203 279.943C14.1592 277.462 14.1195 274.497 12.0785 274.877C10.7879 275.113 10.4901 283.871 11.6337 286.148C12.7654 288.425 14.9216 289.597 15.7754 290.312C16.6291 291.022 18.9123 292.155 18.4835 294.02C18.1618 295.408 16.2042 294.729 16.2042 294.729C16.2042 294.729 15.6324 295.868 14.4927 295.868C13.3571 295.868 6.40802 291.61 4.79981 289.526C3.04865 287.242 1.25781 277.952 1.25781 275.305C1.25781 274.464 3.22734 270.063 4.64098 265.981C5.6337 263.11 6.14993 260.266 6.38421 259.501C6.95205 257.653 6.43183 257.087 6.76936 255.596C7.02349 254.512 7.11087 253.978 7.87725 252.449C8.05197 252.097 8.52451 246.854 8.73099 243.224C9.59665 234.769 10.7204 194.287 12.0864 186.911C13.5794 178.824 16.3591 172.724 17.4431 167.333C18.5192 161.936 17.7727 156.348 18.2532 144.966C18.4279 140.754 19.5676 131.779 18.968 123.992C18.3723 116.202 19.2181 99.6151 25.2618 91.3358C28.5537 86.8249 36.6781 85.2326 44.6874 83.1082C52.6927 80.9838 61.6987 78.0532 64.3116 73.6733C65.0263 72.4702 66.428 67.5185 66.7417 64.0201V64.0161C66.7536 63.897 66.7655 63.7898 66.7695 63.6786L93.2792 63.9685C93.2792 64.036 93.2792 64.0956 93.2831 64.1631C93.3348 67.9037 94.935 72.6925 95.5465 73.725C98.1594 78.1009 107.332 80.9838 115.337 83.1082C123.347 85.2326 131.471 86.8249 134.767 91.3358C140.807 99.6151 141.656 116.202 141.061 123.992C141.001 124.791 140.958 125.605 140.93 126.419C140.831 129.246 140.918 132.145 141.073 134.849V134.857C141.18 136.822 141.323 138.689 141.458 140.349V140.356C141.593 142.088 141.716 143.596 141.764 144.768V144.774C141.772 144.84 141.776 144.905 141.776 144.966C141.835 146.402 141.875 147.749 141.903 149.015C141.934 150.34 141.946 151.573 141.95 152.734V152.739C141.958 153.856 141.958 154.901 141.958 155.885C141.958 156.815 141.95 157.695 141.962 158.532V158.537C141.958 159.323 141.962 160.077 141.978 160.793C141.994 161.441 142.01 162.063 142.046 162.668C142.073 163.218 142.105 163.757 142.153 164.28V164.285C142.2 164.753 142.248 165.215 142.308 165.672C142.363 166.089 142.431 166.502 142.506 166.915C142.53 167.058 142.558 167.196 142.586 167.333C142.633 167.564 142.685 167.8 142.737 168.037C143.904 173.257 146.513 179.176 147.942 186.911C149.304 194.293 150.432 234.841 151.298 243.246C151.508 246.937 151.965 252.196 152.144 252.554C152.902 254.077 152.985 254.611 153.24 255.689C153.581 257.174 153.065 257.741 153.629 259.589C153.867 260.348 154.383 263.187 155.376 266.053C156.782 270.124 158.747 274.513 158.747 275.35Z"
                                stroke="#8D939F" stroke-width="2.38" mask="url(#path-1-outside-1_5761_338270)" />
                        </g>

                        <g class="skin" data-body-part="skin">
                            <g class="head-and-neck js-body-area" data-body-part="head-and-neck">
                                <path
                                    d="M105.764 12.7532L105.764 12.7531C102.967 7.64971 97.3152 3.97088 90.9793 2.14715C84.6453 0.323997 77.7448 0.389824 72.5362 2.64338L72.377 2.71227L72.2057 2.68494C63.4416 1.28728 58.3132 6.59688 54.4089 10.9553C53.4906 11.9804 52.0657 14.2797 50.5274 17.3826C48.9977 20.4682 47.3801 24.299 46.065 28.351C44.7492 32.4053 43.742 36.6633 43.4221 40.6077C43.1014 44.5615 43.4763 48.14 44.8635 50.8809L44.8636 50.881C49.5164 60.0759 59.3651 62.4702 62.9448 62.934L62.9459 62.9341C63.2331 62.9718 63.5384 63.0124 63.8697 63.0564C64.2672 63.1092 64.7023 63.1669 65.189 63.2309L93.8965 63.8172C103.06 62.6261 112.183 59.6593 118.579 53.2798C114.19 52.3295 111.623 49.8761 110.244 46.8453C108.772 43.6119 108.675 39.7783 109.005 36.5436C109.325 33.4008 109.267 28.8106 108.745 24.3077C108.222 19.7885 107.241 15.4475 105.764 12.7532Z"
                                    fill="#8D939F" stroke="#8D939F" stroke-width="1.19207" />
                                <path
                                    d="M83.9058 61.0078H80.9219C80.9845 67.0947 81.458 70.3314 82.7402 75.9273L88.3816 71.4514C87.799 69.1209 87.4723 69.3062 86.8897 66.9756C85.872 64.0936 85.2514 62.5048 83.9058 61.0078Z"
                                    fill="#8D939F" />
                                <path
                                    d="M75.7036 61.0078H78.6875C78.6249 67.0947 78.1514 70.3314 76.8692 75.9273L71.2278 71.4514C71.8104 69.1209 72.1371 69.3062 72.7197 66.9756C73.7373 64.0936 74.3579 62.5048 75.7036 61.0078Z"
                                    fill="#8D939F" />
                            </g>
                            <g class="upper-extremity js-body-area" data-body-part="upper-extremity">
                                <path
                                    d="M56.5402 95.9712C49.9644 92.9812 45.9419 88.3233 41.8956 87.3901C37.0868 86.2783 28.748 90.5748 24.8923 97.7065C22.192 102.698 19.2457 113.05 21.1914 124.375C32.8539 121.139 32.8896 110.707 39.6917 104.505C44.1431 100.446 51.7791 96.7734 56.5402 95.9712Z"
                                    fill="#8D939F" />
                                <path
                                    d="M18.9226 170.404C18.9703 167.772 20.0186 136.516 21.0074 127.649C24.6209 127.05 33.2218 119.461 35.0365 114.021C37.1371 121.014 38.8128 131.096 38.9637 137.442C39.0907 142.814 37.7447 152.975 37.3039 156.93C36.8631 160.885 34.0041 178.881 28.4131 181.75C29.0286 175.684 33.8413 148.857 28.4567 148.185C22.3773 147.426 23.3383 171.135 23.7473 179.369C21.059 174.718 18.875 173.036 18.9226 170.404Z"
                                    fill="#8D939F" />
                                <path
                                    d="M17.6425 174.293C15.9787 180.309 14.4936 184.821 13.7153 190.506C11.7854 204.565 11.6822 234.913 9.60938 249.639C9.9747 250.029 10.9555 250.162 11.3526 249.85C13.8821 228.241 18.9807 200.027 19.203 186.751C19.2944 181.231 17.6068 178.427 17.6425 174.293Z"
                                    fill="#8D939F" />
                                <path
                                    d="M19.6014 177.164C19.8874 179.026 20.6974 183.158 20.4909 187.544C19.9469 199.34 15.4598 230.623 12.6484 250.137C12.9701 250.668 13.7166 250.772 14.1772 250.587C18.2911 227.011 24.8669 197.704 25.0853 187.896C25.1806 183.582 20.9317 179.979 19.6014 177.164Z"
                                    fill="#8D939F" />
                                <path
                                    d="M32.3744 181.606C21.3631 186.944 25.064 218.179 15.375 250.982C15.653 251.539 16.3995 251.643 16.868 251.546C23.6146 229.587 31.4571 202.614 32.3744 181.606Z"
                                    fill="#8D939F" />
                                <path
                                    d="M11.5199 271.587C12.4173 269.067 12.8501 263.169 12.5126 258.59C12.5126 258.59 9.76872 257.846 8.69658 257.794C6.56421 265.08 -1.72703 278.835 11.3451 289.117C5.62705 278.647 10.4557 274.579 11.5199 271.587Z"
                                    fill="#8D939F" />
                                <path
                                    d="M18.2492 269.059C17.872 265.908 16.7363 262.264 15.1122 259.077C14.3736 262.048 13.3928 268.371 13.9408 270.776C14.5602 273.485 15.7595 274.97 15.6602 279.93C16.7204 277.386 18.6264 272.209 18.2492 269.059Z"
                                    fill="#8D939F" />
                                <path
                                    d="M103.312 95.9712C109.892 92.9812 113.911 88.3233 117.957 87.3901C122.766 86.2783 131.105 90.5748 134.96 97.7065C137.661 102.698 140.607 113.05 138.661 124.375C127.003 121.139 126.963 110.707 120.161 104.505C115.71 100.446 108.074 96.7734 103.312 95.9712Z"
                                    fill="#8D939F" />
                                <path
                                    d="M140.956 170.404C140.908 167.772 139.86 136.516 138.871 127.649C135.258 127.05 126.657 119.461 124.842 114.021C122.741 121.014 121.066 131.096 120.915 137.442C120.788 142.814 122.134 152.975 122.575 156.93C123.015 160.885 125.874 178.881 131.465 181.75C130.85 175.684 126.037 148.857 131.422 148.185C137.501 147.426 136.54 171.135 136.131 179.369C138.819 174.718 141.003 173.036 140.956 170.404Z"
                                    fill="#8D939F" />
                                <path
                                    d="M142.228 174.293C143.892 180.309 145.377 184.821 146.155 190.506C148.089 204.565 148.189 234.913 150.261 249.639C149.896 250.029 148.915 250.162 148.522 249.85C145.989 228.241 140.89 200.027 140.668 186.751C140.576 181.231 142.264 178.427 142.228 174.293Z"
                                    fill="#8D939F" />
                                <path
                                    d="M140.282 177.164C139.996 179.026 139.186 183.158 139.393 187.544C139.937 199.34 144.424 230.623 147.235 250.137C146.913 250.668 146.167 250.772 145.706 250.587C141.592 227.011 135.017 197.704 134.798 187.896C134.707 183.582 138.952 179.979 140.282 177.164Z"
                                    fill="#8D939F" />
                                <path
                                    d="M127.5 181.606C138.511 186.944 134.81 218.179 144.499 250.982C144.221 251.539 143.475 251.643 143.006 251.546C136.26 229.587 128.417 202.614 127.5 181.606Z"
                                    fill="#8D939F" />
                                <path
                                    d="M148.357 271.587C147.46 269.067 147.027 263.169 147.364 258.59C147.364 258.59 150.108 257.846 151.18 257.794C153.313 265.08 161.604 278.835 148.532 289.117C154.25 278.647 149.421 274.579 148.357 271.587Z"
                                    fill="#8D939F" />
                                <path
                                    d="M141.611 269.059C141.988 265.908 143.124 262.264 144.748 259.077C145.487 262.048 146.468 268.371 145.92 270.776C145.3 273.485 144.101 274.97 144.2 279.93C143.14 277.386 141.234 272.209 141.611 269.059Z"
                                    fill="#8D939F" />
                            </g>
                            <g class="back js-body-area" data-body-part="back">
                                <path
                                    d="M88.2145 70.8059L85.702 72.9446L82.7181 75.9285C83.6116 83.3897 84.522 81.4994 84.522 88.5159C84.522 97.8116 82.3222 104.133 81.7186 113.103C80.845 126.001 81.25 161.109 81.25 161.109C85.3995 145.741 90.7681 137.067 93.6788 127.803C97.7965 114.7 97.1573 103.315 99.9964 96.6601C101.783 92.4748 106.612 91.5774 114.502 85.9705C102.343 82.2935 91.6698 78.9124 88.2145 70.8059Z"
                                    fill="#8D939F" />
                                <path
                                    d="M71.3714 70.8059L73.8839 72.9446L76.8678 75.9285C75.9744 83.3897 75.0639 81.4994 75.0639 88.5159C75.0639 97.8116 77.2638 104.133 77.8674 113.103C78.7409 126.001 78.3359 161.109 78.3359 161.109C74.1864 145.741 68.8178 137.067 65.9072 127.803C61.7894 114.7 62.4287 103.315 59.5895 96.6601C57.8026 92.4748 52.9741 91.5774 45.084 85.9705C57.2428 82.2935 67.9161 78.9124 71.3714 70.8059Z"
                                    fill="#8D939F" />
                                <path
                                    d="M56.5717 98.3244C59.6611 101.017 57.755 114.113 62.5399 125.672C49.984 125.473 46.3943 112.516 41.6094 105.937C45.1991 102.748 50.6789 99.2218 56.5717 98.3244Z"
                                    fill="#8D939F" />
                                <path
                                    d="M62.508 127.193C57.3379 129.508 47.915 131.763 42.7449 131.267C41.2955 128.459 37.6463 116.05 36.8203 112.25C47.7839 118.198 50.7145 126.204 62.508 127.193Z"
                                    fill="#8D939F" />
                                <path
                                    d="M63.1669 128.763C57.155 132.448 48.9789 134.044 43.7969 133.647C44.3449 147.377 46.1914 164.944 47.6725 173.543C51.3257 187.836 59.1047 193.017 58.5567 204.133C63.9968 192.541 64.6599 188.407 76.1159 162.791C72.8042 153.758 66.6573 138.762 63.1669 128.763Z"
                                    fill="#8D939F" />
                                <path
                                    d="M48.6262 182.158C49.1385 185.05 55.1226 194.952 55.5951 198.508C55.8533 200.464 55.746 202.863 54.0664 204.184C51.8029 205.967 42.7255 207.528 38.4688 209.125C40.065 199.277 47.9353 197.242 48.6262 182.158Z"
                                    fill="#8D939F" />
                                <path
                                    d="M79.3414 185.065C79.2468 185.065 79.2494 182.176 79.009 180.79C78.761 179.348 78.1219 177.973 77.608 176.585C77.3064 175.767 76.8641 175.636 76.1355 176.102C75.8363 176.293 75.5653 176.541 75.3276 176.805C74.328 177.896 73.3411 179.001 72.362 180.108C71.2959 181.312 70.2119 182.501 69.1867 183.736C67.7678 185.443 66.8551 187.437 66.0191 189.48C64.93 192.136 64.3906 194.892 64.2372 197.746C64.2065 198.344 64.4238 198.648 64.9965 198.766C66.1495 199.003 67.0136 199.673 67.7627 200.563C69.7696 202.948 70.7564 205.822 71.7458 208.703C72.7199 211.528 73.6326 214.376 74.6961 217.168C75.6446 219.655 76.9254 221.989 78.5693 224.101C78.7099 224.28 78.963 224.37 79.165 224.5C79.257 224.28 79.4206 224.06 79.4258 223.838C79.436 223.304 79.3439 222.769 79.3439 222.235C79.3388 209.843 79.3414 197.454 79.3414 185.065Z"
                                    fill="#8D939F" />
                                <path
                                    d="M103.328 98.3244C100.238 101.017 102.144 114.113 97.3594 125.672C109.919 125.473 113.505 112.516 118.29 105.937C114.7 102.748 109.22 99.2218 103.328 98.3244Z"
                                    fill="#8D939F" />
                                <path
                                    d="M97.3594 127.193C102.533 129.508 111.952 131.763 117.126 131.267C118.572 128.459 122.221 116.05 123.047 112.25C112.083 118.198 109.153 126.204 97.3594 127.193Z"
                                    fill="#8D939F" />
                                <path
                                    d="M96.7148 128.763C102.727 132.448 110.903 134.044 116.085 133.647C115.537 147.377 113.69 164.944 112.209 173.543C108.556 187.836 100.777 193.017 101.325 204.133C95.8848 192.541 95.2216 188.407 83.7656 162.791C87.0773 153.758 93.2243 138.762 96.7148 128.763Z"
                                    fill="#8D939F" />
                                <path
                                    d="M111.278 182.158C110.766 185.05 104.782 194.952 104.309 198.508C104.051 200.464 104.158 202.863 105.838 204.184C108.102 205.967 117.179 207.528 121.44 209.125C119.84 199.277 111.969 197.242 111.278 182.158Z"
                                    fill="#8D939F" />
                                <path
                                    d="M80.462 218.05C80.4568 219.964 80.3904 221.879 80.375 223.794C80.3725 224.024 80.508 224.26 80.5796 224.492C80.7994 224.354 81.0934 224.265 81.2264 224.068C81.9805 222.948 82.7501 221.828 83.4199 220.657C85.4166 217.17 86.475 213.315 87.743 209.539C88.6225 206.926 89.4662 204.285 91.0078 201.964C91.8847 200.645 92.7974 199.338 94.4617 198.86C95.6173 198.528 95.6326 198.499 95.5482 197.28C95.221 192.622 93.9376 188.227 91.1382 184.484C89.0213 181.654 86.4878 179.134 84.1281 176.488C83.9312 176.268 83.6398 176.117 83.3713 175.981C82.9111 175.751 82.4612 175.823 82.295 176.332C81.7198 178.096 80.9221 179.844 80.7202 181.657C80.4262 184.311 80.5463 187.01 80.5361 189.692C80.5156 194.752 80.531 199.808 80.531 204.868C80.508 204.868 80.4875 204.868 80.4671 204.868C80.4671 209.263 80.4773 213.657 80.462 218.05Z"
                                    fill="#8D939F" />
                            </g>
                            <g class="torso internal-organs back js-body-area" data-body-part="internal-organs">
                                <path
                                    d="M80.462 218.05C80.4568 219.964 80.3904 221.879 80.375 223.794C80.3725 224.024 80.508 224.26 80.5796 224.492C80.7994 224.354 81.0934 224.265 81.2264 224.068C81.9805 222.948 82.7501 221.828 83.4199 220.657C85.4166 217.17 86.475 213.315 87.743 209.539C88.6225 206.926 89.4662 204.285 91.0078 201.964C91.8847 200.645 92.7974 199.338 94.4617 198.86C95.6173 198.528 95.6326 198.499 95.5482 197.28C95.221 192.622 93.9376 188.227 91.1382 184.484C89.0213 181.654 86.4878 179.134 84.1281 176.488C83.9312 176.268 83.6398 176.117 83.3713 175.981C82.9111 175.751 82.4612 175.823 82.295 176.332C81.7198 178.096 80.9221 179.844 80.7202 181.657C80.4262 184.311 80.5463 187.01 80.5361 189.692C80.5156 194.752 80.531 199.808 80.531 204.868C80.508 204.868 80.4875 204.868 80.4671 204.868C80.4671 209.263 80.4773 213.657 80.462 218.05Z"
                                    fill="#8D939F" />
                                <path
                                    d="M79.3414 185.065C79.2468 185.065 79.2494 182.176 79.009 180.79C78.761 179.348 78.1219 177.973 77.608 176.585C77.3064 175.767 76.8641 175.636 76.1355 176.102C75.8363 176.293 75.5653 176.541 75.3276 176.805C74.328 177.896 73.3411 179.001 72.362 180.108C71.2959 181.312 70.2119 182.501 69.1867 183.736C67.7678 185.443 66.8551 187.437 66.0191 189.48C64.93 192.136 64.3906 194.892 64.2372 197.746C64.2065 198.344 64.4238 198.648 64.9965 198.766C66.1495 199.003 67.0136 199.673 67.7627 200.563C69.7696 202.948 70.7564 205.822 71.7458 208.703C72.7199 211.528 73.6326 214.376 74.6961 217.168C75.6446 219.655 76.9254 221.989 78.5693 224.101C78.7099 224.28 78.963 224.37 79.165 224.5C79.257 224.28 79.4206 224.06 79.4258 223.838C79.436 223.304 79.3439 222.769 79.3439 222.235C79.3388 209.843 79.3414 197.454 79.3414 185.065Z"
                                    fill="#8D939F" />
                            </g>
                            <g class="lower-extremity js-body-area" data-body-part="lower-extremity">
                                <path
                                    d="M31.4892 253.604C28.4674 260.089 28.5349 269.349 29.206 276.851C30.5124 291.414 34.1378 303.595 35.893 316.25C42.8063 276.838 33.7288 272.879 31.4892 253.604Z"
                                    fill="#8D939F" />
                                <path
                                    d="M54.3259 277.915C42.3338 276.848 39.8243 292.426 39.447 311.8C39.1651 326.099 45.2683 351.687 41.2935 362.794C41.1783 362.754 42.0281 369.409 41.6707 369.453C53.6906 360.566 49.3822 301.491 54.3259 277.915Z"
                                    fill="#8D939F" />
                                <path
                                    d="M59.0913 277.473C64.317 296.089 65.3614 315.007 64.4242 330.477C63.3243 348.636 60.8385 365.854 66.1873 372.763C66.1953 373.137 64.0112 378.414 63.6816 378.422C50.4268 363.849 50.6611 302.606 59.0913 277.473Z"
                                    fill="#8D939F" />
                                <path
                                    d="M67.6207 326.656C67.5175 308.759 63.3281 277.721 63.3281 277.721L74.0456 268.313C74.0456 268.313 70.8848 311.281 67.6207 326.656Z"
                                    fill="#8D939F" />
                                <path
                                    d="M47.3244 365.848C49.2265 367.834 51.335 381.339 51.2833 386.064C51.2357 390.789 50.9221 420.333 50.8704 425.058C50.8228 429.783 47.5349 431.86 43.6712 433.008C41.8168 426.297 37.7744 412.435 38.2867 397.123C38.4733 391.484 41.6023 380.052 42.0074 374.354C44.4296 372.003 45.7599 368.199 47.3244 365.848Z"
                                    fill="#8D939F" />
                                <path
                                    d="M57.3051 373.519C55.3594 375.473 52.7386 381.361 52.6869 386.087C52.6393 390.812 52.3256 420.356 52.274 425.081C52.2223 429.806 56.0344 432.574 59.8743 433.789C61.8676 427.11 64.5957 409.837 64.3137 397.686C64.1867 392.047 61.824 383.406 62.229 381.441C59.8624 379.046 58.822 375.898 57.3051 373.519Z"
                                    fill="#8D939F" />
                                <path
                                    d="M40.4375 428.295C42.8756 436.221 45.5242 439.275 46.9855 446.101C48.8637 454.857 49.4753 467.198 47.6407 483.586C45.6434 468.223 44.0232 463.191 43.0146 453.745C42.1728 445.874 41.4977 436.571 40.4375 428.295Z"
                                    fill="#8D939F" />
                                <path
                                    d="M61.3556 433.645C59.2868 441.697 56.0823 446.046 54.891 452.939C53.3622 461.782 54.3907 473.131 56.3999 484.281C56.7017 473.77 57.488 468.858 58.1988 459.388C58.7905 451.494 60.5734 441.956 61.3556 433.645Z"
                                    fill="#8D939F" />
                                <path
                                    d="M47.0149 484.783C46.2882 482.182 45.8236 478.1 45.0175 474.2C44.1995 478.942 42.7938 482.186 41.2055 483.802C38.0843 486.971 32.3504 490.576 27.3828 492.621C39.7799 493.014 44.0963 490.076 47.0149 484.783Z"
                                    fill="#8D939F" />
                                <path
                                    d="M92.2531 326.656C92.3563 308.759 96.5495 277.721 96.5495 277.721L85.8281 268.313C85.8281 268.313 88.989 311.281 92.2531 326.656Z"
                                    fill="#8D939F" />
                                <path
                                    d="M100.799 277.473C95.5734 296.089 94.5291 315.007 95.4662 330.477C96.5662 348.636 99.0519 365.854 93.7031 372.763C93.6952 373.137 95.8792 378.414 96.2088 378.422C109.464 363.849 109.229 302.606 100.799 277.473Z"
                                    fill="#8D939F" />
                                <path
                                    d="M105.547 277.915C117.539 276.848 120.049 292.426 120.426 311.8C120.708 326.099 114.605 351.687 118.579 362.794C118.695 362.754 117.845 369.409 118.202 369.453C106.182 360.566 110.491 301.491 105.547 277.915Z"
                                    fill="#8D939F" />
                                <path
                                    d="M128.393 253.604C131.415 260.089 131.352 269.349 130.677 276.851C129.37 291.414 125.745 303.595 123.99 316.25C117.076 276.838 126.154 272.879 128.393 253.604Z"
                                    fill="#8D939F" />
                                <path
                                    d="M102.576 373.519C104.521 375.473 107.142 381.361 107.194 386.087C107.242 390.812 107.555 420.356 107.607 425.081C107.658 429.806 103.846 432.574 100.011 433.789C98.0132 427.11 95.2851 409.837 95.5671 397.686C95.6942 392.047 98.0568 383.406 97.6518 381.441C100.018 379.046 101.059 375.898 102.576 373.519Z"
                                    fill="#8D939F" />
                                <path
                                    d="M112.554 365.848C110.652 367.834 108.543 381.339 108.595 386.064C108.642 390.789 108.956 420.333 109.008 425.058C109.059 429.783 112.343 431.86 116.207 433.008C118.061 426.297 122.104 412.435 121.595 397.123C121.405 391.484 118.276 380.052 117.871 374.354C115.448 372.003 114.118 368.199 112.554 365.848Z"
                                    fill="#8D939F" />
                                <path
                                    d="M98.5156 433.645C100.584 441.697 103.789 446.046 104.98 452.939C106.509 461.782 105.481 473.131 103.471 484.281C103.169 473.77 102.383 468.858 101.672 459.388C101.081 451.494 99.2979 441.956 98.5156 433.645Z"
                                    fill="#8D939F" />
                                <path
                                    d="M119.448 428.295C117.01 436.221 114.362 439.275 112.9 446.101C111.022 454.857 110.411 467.198 112.245 483.586C114.242 468.223 115.863 463.191 116.871 453.745C117.713 445.874 118.388 436.571 119.448 428.295Z"
                                    fill="#8D939F" />
                                <path
                                    d="M112.875 484.783C113.602 482.182 114.066 478.1 114.872 474.2C115.69 478.942 117.096 482.186 118.684 483.802C121.805 486.971 127.54 490.576 132.507 492.621C120.11 493.014 115.794 490.076 112.875 484.783Z"
                                    fill="#8D939F" />
                            </g>
                            <path
                                d="M74.4269 219.357C82.4957 231.995 81.9756 255.619 73.3468 265.834C65.8935 274.653 47.3335 273.895 40.9484 265.117C32.0734 252.915 34.4957 224.587 40.5473 211.948C53.0516 204.539 68.141 209.505 74.4269 219.357Z"
                                fill="#8D939F" />
                            <path
                                d="M85.4468 219.357C77.378 231.995 77.8982 255.619 86.527 265.834C93.9803 274.653 112.54 273.895 118.925 265.117C127.8 252.915 125.378 224.587 119.326 211.948C106.822 204.539 91.7328 209.505 85.4468 219.357Z"
                                fill="#8D939F" />

                        </g>
                    </svg>

                    <svg width="243" height="504" viewbox="0 0 243 504" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="human-body-areas_male js-human-body-svg">
                        <g class="nerv-system js-body-area" data-body-part="nerv-system">
                            <path
                                d="M75.9756 467.6C74.27 467.6 73.0534 467.714 72.1438 467.959C68.3617 468.982 64.9237 472.268 63.5885 476.137C62.3373 479.761 63.0139 483.614 65.4433 486.705C67.8079 489.712 70.8828 490.642 73.5954 491.462C75.7747 492.122 77.6546 492.689 78.9356 494.173C79.3942 494.702 79.8377 495.37 80.3038 496.076C80.8117 496.841 81.3082 497.594 81.9033 498.313C84.0863 500.969 90.0216 501.954 93.2508 501.954C95.775 501.954 97.8936 501.506 99.5461 500.618L100.376 500.169L100.774 499.235C103.829 491.978 103.298 486.95 102.684 481.127L102.677 481.055L102.684 480.984C102.98 478.544 103.359 475.325 103.692 472.074L103.708 471.947C103.958 469.498 104.246 466.724 103.984 463.92L102.828 455.806C102.787 455.569 102.749 455.34 102.718 455.137C102.643 454.651 102.567 454.173 102.427 453.674C102.252 453.044 102.063 452.423 101.873 451.801C101.646 451.061 101.422 450.321 101.225 449.572C100.554 447.006 100.437 442.498 100.975 439.732C101.555 436.738 101.976 434.184 102.385 431.714C102.851 428.89 103.291 426.217 103.95 422.948L105.443 415.747C105.766 415.269 106.023 414.842 106.156 414.579C108.002 410.985 109.055 407.577 109.385 404.16C109.961 398.147 109.412 392.205 107.699 385.993C107.289 384.505 106.906 383.206 106.554 382.027C105.678 379.066 105.049 376.935 104.716 374.136L104.689 373.895L108.218 368.909C111.553 360.253 112.773 354.65 114.187 348.163C114.593 346.302 115.013 344.369 115.506 342.259C117.579 333.392 119.11 323.805 119.406 317.834C119.679 312.375 119.842 305.846 120.001 299.536C120.168 292.872 120.338 286.068 120.63 280.427C120.68 279.445 120.426 274.98 119.834 265.338L119.815 265.047C119.615 261.752 119.406 258.352 119.395 257.908L119.41 254.289C119.429 253.904 119.425 253.587 119.395 253.286C119.315 252.42 119.004 251.612 118.5 250.961L118.193 250.559L118.523 250.178C119.569 248.96 120.505 247.671 121.305 246.339L121.737 245.615L122.169 246.339C122.965 247.671 123.905 248.96 124.951 250.178L125.281 250.559L124.974 250.961C124.466 251.616 124.155 252.424 124.075 253.295C124.049 253.599 124.045 253.917 124.064 254.263L124.079 257.815C124.068 258.348 123.859 261.765 123.659 265.068L123.64 265.338C123.048 274.976 122.791 279.445 122.84 280.431C123.136 286.068 123.306 292.872 123.469 299.456C123.632 305.85 123.795 312.375 124.068 317.834C124.364 323.809 125.895 333.396 127.968 342.259C128.461 344.369 128.881 346.302 129.283 348.15C130.697 354.65 131.917 360.253 135.256 368.909L138.785 373.89L138.758 374.136C138.425 376.935 137.796 379.066 136.92 382.018C136.56 383.232 136.181 384.517 135.775 385.993C134.062 392.201 133.513 398.142 134.089 404.16C134.419 407.577 135.472 410.985 137.314 414.579C137.447 414.837 137.708 415.26 138.027 415.747L138.118 415.966L139.524 422.948C140.183 426.217 140.623 428.89 141.089 431.714C141.498 434.184 141.919 436.738 142.499 439.732C143.033 442.502 142.92 447.006 142.249 449.568C142.056 450.312 141.832 451.044 141.608 451.78C141.415 452.41 141.226 453.04 141.047 453.67C140.907 454.173 140.831 454.651 140.759 455.116L140.737 455.247C140.71 455.421 140.68 455.611 140.642 455.827L139.482 463.954C139.228 466.728 139.516 469.498 139.766 471.943L139.782 472.078C140.111 475.309 140.494 478.535 140.79 480.984L140.797 481.055L140.79 481.127C140.176 486.95 139.645 491.978 142.7 499.235L143.094 500.169L143.928 500.618C145.577 501.506 147.695 501.954 150.219 501.954C153.452 501.954 159.388 500.969 161.571 498.313C162.166 497.586 162.67 496.829 163.159 496.093C163.636 495.37 164.08 494.702 164.535 494.177C165.819 492.689 167.699 492.122 169.875 491.462C172.592 490.642 175.666 489.712 178.031 486.705C180.46 483.614 181.135 479.761 179.884 476.137C178.546 472.264 175.109 468.978 171.33 467.959C169.522 467.468 166.373 467.477 161.055 467.951L160.437 468.006L160.555 466.496C160.559 466.437 160.57 466.365 160.578 466.293C160.642 465.781 160.71 465.206 160.642 464.534C160.578 463.942 160.521 463.345 160.464 462.753C160.275 460.842 160.081 458.863 159.744 456.88C159.115 453.192 159.278 449.281 160.267 444.57C162.348 434.628 164.5 424.344 167.377 414.444C167.529 413.928 167.684 413.408 167.847 412.879C168.821 409.632 169.92 405.987 169.901 402.062L169.894 400.29L169.924 400.193C170.231 399.238 170.424 398.227 170.508 397.191C170.674 395.026 170.735 389.875 170.477 387.207C170.163 383.984 169.272 380.762 168.416 377.641L168.378 377.51C168.109 376.529 167.836 375.535 167.578 374.529C165.926 368.11 164.565 365.027 162.681 360.756L162.154 359.559L162.355 358.908C162.439 358.637 162.533 358.371 162.628 358.104C162.924 357.276 163.269 356.303 163.394 355.216L163.462 354.65C163.739 352.269 164.027 349.808 163.97 347.279C163.909 344.877 163.761 342.471 163.617 340.145C163.447 337.426 163.291 334.884 163.261 332.301L163.257 331.933L165.308 319.318C165.467 318.515 165.634 317.686 165.751 316.794C166.123 313.952 166.513 311.115 166.907 308.277C167.874 301.274 168.863 294.132 169.522 287.049C170.258 279.145 170.421 271.136 170.58 263.393L170.599 262.37C170.693 257.68 170.565 252.542 170.189 246.203C169.92 241.636 169.329 237.061 168.787 233.183C168.469 230.895 167.385 229.246 165.732 228.536L165.368 228.379L165.402 227.944C165.471 227.005 165.812 220.848 165.816 220.784L165.899 220.446C166.062 219.93 166.365 218.983 166.168 217.883L165.918 216.463C165.308 213.033 164.679 209.498 163.905 206.026C163.341 203.476 162.586 200.503 161.286 197.763L161.12 197.416L161.351 197.116C162.109 196.126 162.446 194.79 162.234 193.636C161.453 189.432 160.695 185.626 159.914 182.002C159.63 180.679 158.815 179.66 157.739 179.275L157.174 179.072L157.424 178.471C160.036 172.264 161.703 165.337 162.829 156.021C162.943 155.086 163.219 152.249 163.219 152.249L163.42 150.198L164.209 152.063C164.243 152.135 164.644 152.955 165.099 153.881L166.134 156C167.802 159.413 169.496 162.884 171.353 166.263C171.887 167.24 172.623 168.191 173.669 169.257L173.945 169.536L173.794 169.917C173.578 170.475 173.468 171.075 173.487 171.621C173.498 172.018 173.494 172.42 173.494 172.822C173.487 174.234 173.479 175.82 173.942 177.414C174.48 179.287 175.264 180.983 176.018 182.624C176.276 183.182 176.523 183.719 176.758 184.256C177.015 184.844 177.307 185.419 177.599 185.994C178.02 186.823 178.418 187.605 178.63 188.329C181.048 196.49 184.133 204.728 187.806 212.817C190.148 217.972 192.596 223.161 194.961 228.18C196.458 231.352 197.944 234.498 199.411 237.657C199.93 238.773 200.665 239.522 201.594 239.877L201.946 240.008V240.427C201.946 242.66 201.992 244.901 202.037 247.079L202.072 248.998C201.738 252.022 202.731 254.716 203.531 256.885C203.671 257.266 203.807 257.642 203.94 258.014C204.747 260.336 205.664 262.776 207.165 264.924L207.241 265.076C207.306 265.258 207.378 265.448 207.476 265.651L208.215 267.216C208.992 268.861 209.796 270.561 210.664 272.227C211.683 274.185 212.657 275.813 213.643 277.209C214.499 278.414 215.932 278.845 216.985 278.845C217.232 278.845 217.474 278.82 217.709 278.773L218.092 278.697L218.267 279.086C219.438 281.708 221.185 283.103 223.459 283.239C224.467 283.289 225.373 283.027 226.097 282.431L226.381 282.198L226.855 282.528C227.416 282.9 228.106 283.095 228.848 283.095C229.394 283.095 230.77 282.981 231.748 281.919C232.801 280.786 233.036 279.226 233.192 278.194C233.279 277.648 233.245 277.107 233.101 276.532L232.995 276.126L233.309 275.889C234.052 275.327 234.473 274.527 234.753 273.973C234.814 273.644 235.03 272.151 235.216 270.781C235.102 270.426 235 270.083 234.901 269.753L234.863 269.639C234.575 268.683 234.28 267.698 233.84 266.73C232.794 264.412 231.691 262.095 230.618 259.862L229.481 257.477L230.599 257.769C231.532 258.014 232.457 258.23 233.37 258.446L233.87 258.56C236.463 259.173 238.919 258.162 240.503 255.819C240.825 255.342 241.807 253.895 241.397 252.128C240.984 250.356 239.593 249.671 238.998 249.379C236.175 247.984 233.514 246.668 231.869 244.144C231.32 243.298 230.736 242.516 230.171 241.759L229.622 241.019C227.723 238.435 225.028 235.234 220.984 233.361C220.559 233.166 220.158 233.039 219.786 232.933L219.457 232.841L219.4 232.468C219.343 232.079 219.244 231.678 219.112 231.267L217.38 226.036C215.769 221.169 214.101 216.137 212.532 211.113C211.922 209.159 211.433 207.172 210.918 205.07C210.705 204.195 208.276 199.15 206.695 195.966L206.635 195.763L205.896 189.665L205.862 187.525C205.71 177.473 201.416 169.38 196.235 160.601L194.431 158.896L194.423 158.634C194.344 153.801 193.555 149.534 192.013 145.584C191.853 145.174 191.664 144.798 191.444 144.464L191.258 144.172L191.406 143.855C191.6 143.436 191.759 142.975 191.888 142.489C192.115 141.609 192.323 140.552 192.157 139.398C192.077 138.84 192.005 138.281 191.933 137.723C191.664 135.685 191.387 133.583 190.788 131.477C190.076 128.978 189.128 126.593 188.211 124.293L188.071 123.942C187.866 123.422 187.662 122.906 187.461 122.385C187.112 121.493 186.638 120.787 186.047 120.284L185.827 120.094L185.846 119.78C185.854 119.552 185.732 117.937 185.611 116.571C185.471 114.939 185.308 113.086 185.02 111.277C183.94 104.515 181.912 99.5544 178.637 95.6681C174.393 90.6317 168.995 86.9316 162.128 84.3521C161.446 84.0984 159.888 83.6924 159.873 83.6839L157.364 82.9016C156.568 82.6521 155.772 82.39 154.98 82.132L154.866 82.094C153.441 81.6246 151.97 81.1425 150.481 80.7112L150.341 80.6476L146.039 77.7383C145.489 77.3746 144.94 77.011 144.386 76.6516L144.121 76.4781C142.673 75.5309 141.301 74.6302 139.952 73.6914C138.212 72.4778 137.352 70.7355 137.246 68.2025C137.193 66.9677 137.117 65.7329 137.038 64.5023L137.015 64.1429L137.295 63.9568C138.497 63.1745 140.138 61.8466 140.532 59.4066C140.756 58.0069 140.884 56.6325 141.013 55.3005L141.028 55.1398C141.108 54.311 141.188 53.4821 141.294 52.6575L141.582 50.3656L142.044 50.1795C142.548 49.9765 143.09 49.7652 143.636 49.41C144.553 48.8179 144.921 47.8791 145.137 47.3167C146.251 44.7075 147.354 42.1153 148.446 39.5104C148.624 39.0875 148.726 38.6942 148.806 38.377L148.931 37.95L148.942 37.5228C148.995 35.3535 146.956 31.9832 144.587 31.2812L144.007 31.0149L144.019 30.6131C144.121 27.0144 143.867 23.7117 143.242 20.519C141.021 9.12253 132.326 1.164 122.097 1.164C121.21 1.164 120.308 1.23175 119.425 1.35437C114.665 2.01831 110.613 4.08606 107.38 7.49866C102.646 12.497 100.202 19.094 99.9061 27.6699C99.8758 28.651 99.8758 29.632 99.9099 30.6595L99.9251 31.1545L99.4892 31.2517C98.2082 31.5435 97.0408 32.5203 96.1994 34.0045C95.1609 35.8398 94.9297 37.9077 95.5816 39.5443L95.6954 39.8317C96.4193 41.6458 97.1393 43.4558 97.8974 45.2531L97.9997 45.4899C98.428 46.509 98.9131 47.6635 99.6219 48.7333C100.346 49.8243 101.475 50.226 102.082 50.3656L102.445 50.4502L102.608 51.8584C102.737 53.0213 102.84 54.1799 102.938 55.3428L102.968 55.6769C103.056 56.7087 103.147 57.7362 103.253 58.7638C103.473 60.8444 104.481 62.4514 106.338 63.6905L106.615 63.8722L106.592 64.2317C106.478 65.8217 106.361 67.4245 106.213 68.9933C105.929 71.9873 104.89 73.0866 104.018 73.7125C102.665 74.6809 101.24 75.624 99.8606 76.5374L98.2574 77.5987C98.0945 77.7086 97.9239 77.8102 97.7154 77.9328L92.7315 80.8929C91.6475 81.1974 90.5749 81.5146 89.5175 81.8318C88.426 82.1574 87.3647 82.4744 86.3035 82.7704L83.9461 83.426C83.9234 83.4345 81.6228 84.073 80.8724 84.3521C74.0085 86.9316 68.6103 90.6317 64.3658 95.6681C61.0923 99.5544 59.0639 104.515 57.9833 111.277C57.693 113.091 57.533 114.947 57.3894 116.584L57.3746 116.757C57.3125 117.463 57.2488 118.169 57.1779 118.867C57.1453 119.18 57.1377 119.484 57.1571 119.78L57.1764 120.094L56.9543 120.284C56.3634 120.787 55.8897 121.493 55.5448 122.385C55.3537 122.876 55.1601 123.367 54.9645 123.857L54.7985 124.276C53.8779 126.589 52.9274 128.982 52.2167 131.477C51.6141 133.583 51.3389 135.685 51.071 137.719C50.9967 138.286 50.9243 138.844 50.8443 139.402C50.6783 140.552 50.8871 141.609 51.1153 142.489C51.2427 142.975 51.4037 143.436 51.5978 143.855L51.7445 144.172L51.5565 144.464C51.3401 144.794 51.1506 145.17 50.991 145.58C49.4481 149.53 48.6605 153.797 48.5775 158.634L48.5733 158.896L46.7685 160.601C41.5852 169.384 37.2918 177.473 37.1424 187.525L36.359 195.877L33.9785 199.56C33.7014 199.996 32.3912 203.819 32.0921 205.036C31.5608 207.202 31.0783 209.172 30.4711 211.113C28.9195 216.082 27.2526 221.114 25.6403 225.981L23.8919 231.267C23.757 231.678 23.6592 232.079 23.6016 232.468L23.5467 232.841L23.2181 232.933C22.8436 233.043 22.4396 233.17 22.0173 233.365C17.9771 235.234 15.2797 238.435 13.3817 241.019L12.8457 241.742C12.2624 242.524 11.6822 243.302 11.1341 244.144C9.48963 246.668 6.82899 247.984 4.01296 249.375C3.41072 249.671 2.01596 250.36 1.60588 252.128C1.19428 253.895 2.1759 255.342 2.49843 255.815C4.08572 258.162 6.5417 259.173 9.1326 258.56C9.13412 258.56 11.4718 258.014 12.403 257.769L13.5223 257.477L12.3898 259.849C11.318 262.091 10.2105 264.408 9.16216 266.73C8.72858 267.685 8.4337 268.666 8.14679 269.614L8.10511 269.749C8.00316 270.083 7.8993 270.43 7.78257 270.785L8.11989 273.72C8.9105 275.174 9.44377 275.699 9.69808 275.893L10.0108 276.126L9.9069 276.532C9.76022 277.107 9.72917 277.686 9.8152 278.249C9.96188 279.2 10.2044 280.79 11.2482 281.911C12.2374 282.981 13.6098 283.095 14.1545 283.095C14.8977 283.095 15.5863 282.896 16.1442 282.528L16.5661 282.236L16.9083 282.431C17.6307 283.027 18.4732 283.302 19.5508 283.239C21.8176 283.103 23.5629 281.708 24.7356 279.086L24.9103 278.697L25.2939 278.773C25.5292 278.82 25.7722 278.845 26.0163 278.845C27.0733 278.845 28.5063 278.414 29.3576 277.209C30.3438 275.813 31.3194 274.185 32.3396 272.227C33.2087 270.561 34.005 268.874 34.7736 267.246L35.5301 265.647C35.6234 265.448 35.6957 265.262 35.7609 265.076L35.8348 264.928C37.3422 262.772 38.2571 260.332 39.0625 258.014C39.175 257.697 39.2918 257.38 39.4104 257.058L39.4726 256.885C40.2719 254.716 41.2653 252.022 40.9351 249.083L40.9693 247.015C41.0121 244.863 41.0553 242.638 41.0568 240.427V240.008L41.4104 239.877C42.3375 239.522 43.0716 238.778 43.5912 237.657C45.0512 234.519 46.5255 231.394 48.0018 228.265C50.3808 223.224 52.8402 218.01 55.1968 212.817C58.8702 204.728 61.9568 196.49 64.3715 188.329C64.5879 187.601 64.9843 186.819 65.4066 185.99C65.6965 185.419 65.9868 184.844 66.2445 184.256C66.4682 183.745 66.702 183.237 66.9359 182.73C67.7352 180.992 68.5201 179.296 69.0632 177.418C69.5283 175.812 69.5192 174.226 69.5105 172.822C69.5089 172.42 69.5059 172.018 69.5165 171.629C69.5324 171.08 69.4229 170.475 69.2069 169.917L69.0602 169.536L69.3327 169.257C70.3795 168.187 71.1167 167.236 71.6526 166.263C73.5158 162.863 75.2138 159.383 76.8587 156.021C77.4537 154.795 79.4852 149.775 79.5079 149.729L80.3834 147.559L80.5009 149.932C80.5047 149.987 80.7738 155.353 80.9368 156.558C81.6342 161.679 82.3543 166.969 83.9613 172.133C84.4881 173.828 85.2196 176.078 86.1936 178.429L86.4513 179.051L85.8601 179.233C84.7155 179.584 83.8551 180.62 83.5557 182.002C82.775 185.631 82.017 189.437 81.24 193.64C81.0277 194.794 81.365 196.126 82.1231 197.116L82.3505 197.416L82.1837 197.767C80.8875 200.503 80.1333 203.476 79.5648 206.026C78.7954 209.493 78.1662 213.029 77.5598 216.446L77.3059 217.879C77.1088 218.983 77.3969 219.892 77.5712 220.438L77.6508 220.772C77.6546 220.835 77.9995 227.005 78.0715 227.944L78.1056 228.379L77.738 228.536C76.0893 229.242 75.0053 230.895 74.6832 233.183C74.145 237.048 73.5537 241.615 73.2846 246.203C72.9094 252.555 72.7805 257.693 72.8753 262.37L72.8942 263.397C73.0534 271.14 73.2164 279.15 73.9517 287.049C74.6149 294.174 75.6079 301.342 76.5668 308.277C76.961 311.115 77.3514 313.952 77.7228 316.79C77.8403 317.682 78.0033 318.515 78.1624 319.318L78.2837 319.932L80.2053 331.827L80.2129 332.296C80.1825 334.901 80.0234 337.447 79.8566 340.141C79.7126 342.467 79.5648 344.877 79.5041 347.275C79.4435 349.808 79.7353 352.277 80.0158 354.667L80.0802 355.216C80.2053 356.303 80.5502 357.276 80.8269 358.058C80.9406 358.371 81.0353 358.637 81.1149 358.904L81.3158 359.563L80.789 360.76C78.9015 365.04 77.5409 368.127 75.896 374.529C75.6307 375.569 75.3502 376.597 75.0697 377.612C74.198 380.766 73.3074 383.997 72.9966 387.207C72.7388 389.862 72.7995 395.013 72.9662 397.191C73.0458 398.223 73.2429 399.233 73.5499 400.189L73.5802 400.286L73.5689 402.067C73.5537 405.991 74.6528 409.644 75.6231 412.867L75.6989 413.121C75.8353 413.569 75.968 414.009 76.0968 414.448C78.9735 424.344 81.1263 434.628 83.2071 444.57C84.1925 449.281 84.3592 453.192 83.73 456.88C83.3889 458.863 83.1957 460.842 83.01 462.753L82.8318 464.538C82.7598 465.219 82.8356 465.815 82.8849 466.213C82.9038 466.365 82.9114 466.437 82.919 466.504L83.0365 468.006L82.4187 467.951C79.7732 467.714 77.6659 467.6 75.9756 467.6ZM150.223 503.121H150.219C147.536 503.117 145.266 502.63 143.477 501.666L142.306 501.04L141.756 499.73C138.588 492.202 139.118 487.031 139.747 481.064C139.452 478.62 139.073 475.419 138.743 472.209L138.732 472.069C138.474 469.57 138.182 466.733 138.451 463.802L139.71 455.044L140.244 455.015L139.732 454.913C139.812 454.414 139.891 453.898 140.054 453.323C140.229 452.685 140.426 452.046 140.619 451.403C140.839 450.685 141.059 449.966 141.248 449.243C141.877 446.832 141.984 442.591 141.48 439.982C140.896 436.966 140.475 434.404 140.066 431.926C139.6 429.109 139.16 426.45 138.508 423.202L137.125 416.339C136.806 415.857 136.552 415.438 136.408 415.155C134.494 411.421 133.395 407.864 133.05 404.283C132.459 398.109 133.024 392.015 134.779 385.655C135.188 384.166 135.571 382.872 135.919 381.692C136.761 378.851 137.367 376.8 137.693 374.225L134.328 369.442C130.932 360.654 129.7 354.992 128.271 348.438C127.869 346.581 127.449 344.657 126.96 342.555C124.871 333.62 123.325 323.945 123.026 317.898C122.753 312.426 122.59 305.888 122.431 299.57C122.26 292.914 122.093 286.119 121.801 280.494C121.748 279.441 121.991 275.141 122.601 265.258L122.616 264.987C122.81 261.854 123.026 258.298 123.037 257.807L123.022 254.297C122.999 253.925 123.007 253.544 123.041 253.177C123.124 252.246 123.416 251.371 123.89 250.618C123.105 249.679 122.381 248.694 121.737 247.688C121.089 248.694 120.369 249.675 119.584 250.618C120.054 251.367 120.346 252.238 120.433 253.168C120.467 253.532 120.471 253.912 120.448 254.327L120.441 257.9C120.448 258.298 120.664 261.841 120.854 264.966L120.873 265.258C121.479 275.141 121.726 279.446 121.673 280.494C121.381 286.119 121.21 292.914 121.047 299.49C120.884 305.888 120.721 312.421 120.448 317.898C120.149 323.94 118.603 333.62 116.514 342.555C116.022 344.657 115.605 346.581 115.203 348.425C113.774 354.992 112.542 360.654 109.146 369.442L109.078 369.573L105.781 374.229C106.107 376.8 106.713 378.851 107.543 381.654C107.896 382.851 108.282 384.154 108.695 385.655C110.45 392.019 111.015 398.113 110.424 404.283C110.075 407.864 108.98 411.421 107.062 415.155C106.918 415.442 106.664 415.861 106.349 416.343L104.966 423.202C104.314 426.45 103.874 429.109 103.408 431.926C102.999 434.404 102.578 436.966 101.994 439.982C101.487 442.591 101.593 446.832 102.226 449.243C102.415 449.978 102.639 450.701 102.859 451.425C103.052 452.059 103.245 452.689 103.42 453.328C103.583 453.898 103.662 454.414 103.742 454.913C103.776 455.133 103.81 455.353 103.855 455.603L105.019 463.768C105.292 466.733 105 469.57 104.742 472.074L104.731 472.205C104.397 475.44 104.022 478.628 103.727 481.064C104.356 487.031 104.886 492.202 101.714 499.73L101.164 501.04L99.9971 501.666C98.2044 502.63 95.9342 503.121 93.2508 503.121C90.2035 503.121 83.749 502.28 81.1339 499.1C80.5047 498.334 79.9893 497.556 79.489 496.803C79.019 496.093 78.5945 495.454 78.1852 494.985C77.1012 493.729 75.3502 493.2 73.3225 492.583C70.4682 491.72 67.2319 490.744 64.6603 487.47C61.9659 484.045 61.2212 479.761 62.6155 475.719C64.0683 471.511 67.7989 467.938 71.8971 466.826C73.766 466.322 76.798 466.306 81.8881 466.737L81.8616 466.454C81.7971 465.946 81.7099 465.231 81.7933 464.403L81.9753 462.627C82.1648 460.694 82.3581 458.694 82.7029 456.66C83.3056 453.141 83.1426 449.382 82.1913 444.832C80.1143 434.916 77.9691 424.657 75.1039 414.804C74.9788 414.372 74.8461 413.932 74.7135 413.493L74.6377 413.252C73.6371 409.928 72.5077 406.177 72.5266 402.058L72.5342 400.485C72.2158 399.462 72.0111 398.388 71.9266 397.292C71.7565 395.068 71.6943 389.799 71.9592 387.08C72.284 383.76 73.1861 380.479 74.0616 377.307C74.3496 376.263 74.6301 375.244 74.8954 374.208C76.5668 367.704 77.9426 364.579 79.8528 360.253L80.1901 359.483L80.1295 359.28C80.0537 359.031 79.9627 358.781 79.8756 358.532C79.561 357.644 79.1896 356.595 79.0455 355.368L78.9811 354.819C78.6968 352.387 78.4012 349.871 78.4619 347.245C78.5187 344.818 78.6703 342.399 78.8143 340.06C78.9811 337.379 79.1365 334.851 79.1706 332.288V331.929L77.1467 319.568C76.9913 318.786 76.8132 317.893 76.6919 316.959C76.3205 314.126 75.9301 311.288 75.5359 308.455C74.5732 301.507 73.5802 294.322 72.917 287.167C72.1741 279.221 72.0111 271.191 71.8527 263.423L71.8334 262.395C71.7356 257.684 71.8675 252.513 72.2461 246.127C72.5152 241.492 73.1103 236.896 73.6522 233.005C74.0047 230.489 75.2176 228.552 77.0027 227.622C76.9041 226.049 76.654 221.596 76.6161 220.92L76.582 220.818C76.4039 220.251 76.0286 219.067 76.2826 217.655L76.5327 216.243C77.1467 212.792 77.7759 209.24 78.5528 205.747C79.1138 203.231 79.8528 200.309 81.1073 197.56C80.3038 196.338 79.9627 194.782 80.2167 193.407C80.9974 189.187 81.7593 185.373 82.5438 181.732C82.8811 180.163 83.7869 178.937 85.0111 178.336C84.1318 176.154 83.4647 174.099 82.972 172.513C81.3385 167.248 80.6108 161.907 79.9059 156.736C79.8073 156.012 79.6823 153.983 79.5875 152.338C78.947 153.89 78.1321 155.843 77.7758 156.575C76.1272 159.954 74.4216 163.447 72.5417 166.872C72.0005 167.853 71.2842 168.804 70.2996 169.845C70.4875 170.449 70.5762 171.071 70.5588 171.663C70.5482 172.039 70.5512 172.424 70.5527 172.813C70.5614 174.302 70.5721 175.993 70.0551 177.774C69.4866 179.74 68.6812 181.486 67.9042 183.174C67.6332 183.762 67.402 184.261 67.1814 184.768C66.9135 185.377 66.6144 185.973 66.3139 186.565C65.9186 187.343 65.5456 188.075 65.3622 188.692C62.9313 196.909 59.8234 205.201 56.1265 213.342C53.7668 218.543 51.3048 223.761 48.9239 228.806C47.4495 231.936 45.9763 235.06 44.5179 238.194C43.9452 239.429 43.1129 240.33 42.0991 240.824C42.093 242.913 42.0517 245.007 42.0115 247.041L41.9748 249.024C42.3345 252.178 41.2816 255.033 40.4379 257.329L40.3742 257.498C40.2586 257.815 40.1434 258.128 40.035 258.437C39.2091 260.809 38.2703 263.313 36.7039 265.575C36.6345 265.774 36.5531 265.977 36.4538 266.188L35.6957 267.787C34.923 269.428 34.1221 271.123 33.2424 272.811C32.1945 274.819 31.192 276.494 30.1782 277.927C29.0957 279.462 27.3193 280.008 26.0163 280.008C25.8415 280.008 25.6668 279.999 25.4951 279.978C24.1436 282.761 22.164 284.249 19.6027 284.402C19.486 284.41 19.3791 284.41 19.2756 284.41C18.2644 284.41 17.3597 284.135 16.5812 283.59C15.8824 284.025 15.0459 284.258 14.1545 284.258C13.4825 284.258 11.7856 284.11 10.5228 282.748C9.23492 281.361 8.95484 279.539 8.78922 278.443C8.69446 277.834 8.70621 277.217 8.81878 276.6C8.31091 276.109 7.7587 275.314 7.20193 274.274L7.09846 273.986L6.71642 270.65L6.76077 270.514C6.89115 270.121 7.00675 269.745 7.1178 269.377L7.15456 269.254C7.45663 268.256 7.76475 267.237 8.23093 266.205C9.28533 263.871 10.3954 261.549 11.4703 259.3L11.5283 259.181C10.511 259.427 9.34901 259.701 9.34901 259.701C6.36432 260.408 3.4979 259.224 1.66653 256.517C1.26971 255.934 0.0587671 254.149 0.5962 251.836C1.13363 249.519 2.91459 248.643 3.58392 248.313C6.27525 246.981 8.81159 245.734 10.292 243.459C10.859 242.588 11.4495 241.793 12.0225 241.027L12.5778 240.279C14.5513 237.594 17.3628 234.261 21.6179 232.287C21.9776 232.122 22.3164 232.003 22.6393 231.902C22.706 231.563 22.7977 231.216 22.9133 230.866L24.6484 225.613C26.2725 220.712 27.9378 215.689 29.4865 210.728C30.0819 208.825 30.5598 206.876 31.0662 204.808C31.3447 203.679 32.7569 199.374 33.1583 198.846L35.3524 195.446L36.1028 187.453C36.254 177.118 40.6467 168.851 45.9381 159.89L46.037 159.768L47.5397 158.347C47.6478 153.463 48.4653 149.132 50.0344 145.115C50.1795 144.747 50.3467 144.396 50.5335 144.075C50.369 143.673 50.2284 143.25 50.1128 142.815C49.854 141.808 49.6156 140.594 49.8153 139.216C49.8922 138.666 49.9662 138.112 50.0374 137.558C50.3114 135.473 50.5957 133.321 51.2218 131.126C51.9503 128.568 52.9141 126.145 53.8453 123.806L54.0109 123.388C54.205 122.901 54.3975 122.411 54.5885 121.92C54.963 120.956 55.4724 120.157 56.1046 119.556C56.1 119.286 56.1133 119.011 56.1428 118.736C56.2126 118.043 56.2747 117.345 56.3369 116.643L56.3517 116.474C56.4953 114.812 56.6598 112.93 56.9573 111.074C58.075 104.079 60.1876 98.9328 63.6063 94.8732C67.9705 89.6887 73.5082 85.8913 80.5426 83.2526C81.3272 82.9566 83.5974 82.3266 83.6922 82.297L86.0496 81.6414C87.1071 81.3496 88.1607 81.0326 89.2143 80.7197C90.2869 80.3983 91.3443 80.081 92.4169 79.7808L97.1545 76.9433C97.4198 76.7911 97.5714 76.7022 97.7192 76.6008L99.33 75.5351C100.698 74.6302 102.116 73.6913 103.454 72.7356C104.132 72.2493 104.939 71.3699 105.174 68.8707C105.311 67.4287 105.421 65.9569 105.527 64.498C103.575 63.1025 102.461 61.2209 102.218 58.8993C102.108 57.8632 102.021 56.8271 101.93 55.7911L101.9 55.457C101.801 54.3026 101.703 53.1523 101.574 52.0063L101.506 51.4058C100.365 51.0591 99.4058 50.3657 98.7843 49.4269C98.0149 48.264 97.5032 47.0544 97.056 45.9888L96.9536 45.7478C96.1918 43.9421 95.4679 42.1237 94.744 40.3054L94.6303 40.0179C93.8344 38.0262 94.0921 35.5437 95.3163 33.3828C96.2184 31.7928 97.4615 30.6892 98.8525 30.2325C98.8297 29.3445 98.8373 28.4861 98.8638 27.6234C99.1708 18.7304 101.722 11.8712 106.664 6.65292C110.06 3.06693 114.308 0.897675 119.296 0.199951C120.221 0.0688477 121.165 0.00109863 122.097 0.00109863C132.819 0.00109863 141.934 8.33603 144.261 20.2696C144.879 23.4327 145.145 26.6972 145.073 30.2282C147.612 31.0824 150.056 34.6642 149.984 37.5567L149.947 38.2333L149.803 38.7196C149.723 39.0325 149.605 39.4934 149.393 40.0051C148.298 42.61 147.195 45.2022 146.088 47.7945C145.842 48.4288 145.372 49.634 144.159 50.4164C143.556 50.8054 142.988 51.0381 142.526 51.2241L142.325 52.8184C142.222 53.6303 142.143 54.4464 142.067 55.2625L142.048 55.4231C141.919 56.7721 141.786 58.1675 141.559 59.6096C141.119 62.3329 139.444 63.8512 138.099 64.773C138.171 65.8979 138.239 67.0227 138.288 68.1476C138.379 70.3212 139.042 71.687 140.505 72.7061C141.847 73.6364 143.208 74.533 144.572 75.4253L144.913 75.6493C145.467 76.013 146.024 76.3724 146.573 76.7403L150.814 79.6073C152.296 80.0387 153.752 80.5123 155.158 80.9732L155.275 81.0114C156.064 81.2736 156.856 81.5315 157.648 81.781L160.134 82.559C160.176 82.5717 161.734 82.9777 162.461 83.2526C169.492 85.8913 175.033 89.6888 179.395 94.869C182.814 98.9329 184.929 104.079 186.047 111.074C186.343 112.926 186.506 114.803 186.65 116.457C186.688 116.88 186.847 118.732 186.881 119.54C187.521 120.148 188.037 120.948 188.416 121.925C188.617 122.44 188.821 122.956 189.026 123.472L189.162 123.819C190.091 126.153 191.05 128.564 191.781 131.122C192.407 133.321 192.691 135.469 192.964 137.546C193.036 138.108 193.108 138.666 193.188 139.216C193.388 140.594 193.15 141.808 192.888 142.81C192.774 143.25 192.634 143.673 192.471 144.075C192.657 144.396 192.824 144.747 192.968 145.119C194.541 149.137 195.355 153.467 195.462 158.347L197.065 159.89C202.356 168.851 206.748 177.114 206.904 187.504L206.934 189.58L207.658 195.496C208.238 196.672 211.619 203.518 211.918 204.736C212.437 206.846 212.919 208.813 213.518 210.728C215.083 215.744 216.75 220.772 218.361 225.635L220.09 230.866C220.203 231.216 220.298 231.563 220.362 231.902C220.677 231.999 221.026 232.122 221.386 232.287C225.642 234.261 228.454 237.594 230.425 240.279L230.963 241.002C231.547 241.784 232.142 242.583 232.71 243.459C234.192 245.73 236.728 246.986 239.411 248.309C240.025 248.614 241.867 249.519 242.406 251.836C242.944 254.145 241.731 255.934 241.333 256.521C239.506 259.224 236.645 260.403 233.654 259.701L233.154 259.583C232.601 259.452 232.04 259.321 231.479 259.186L231.509 259.249C232.612 261.558 233.722 263.875 234.772 266.205C235.242 267.25 235.553 268.273 235.852 269.267L235.887 269.381C235.997 269.749 236.114 270.125 236.243 270.519L236.288 270.662L236.269 270.81C235.792 274.291 235.754 274.363 235.697 274.477C235.417 275.031 234.977 275.902 234.189 276.608C234.302 277.213 234.31 277.809 234.223 278.388C234.056 279.5 233.772 281.357 232.472 282.757C231.221 284.114 229.523 284.258 228.848 284.258C227.958 284.258 227.12 284.025 226.423 283.59C225.562 284.194 224.569 284.469 223.406 284.402C220.84 284.249 218.858 282.761 217.508 279.978C217.334 279.999 217.16 280.008 216.985 280.008C215.685 280.008 213.912 279.462 212.828 277.927C211.808 276.49 210.808 274.819 209.762 272.815C208.882 271.128 208.075 269.415 207.294 267.757L206.559 266.201C206.453 265.981 206.369 265.774 206.297 265.575C204.736 263.317 203.796 260.809 202.966 258.437C202.841 258.069 202.704 257.697 202.564 257.329C201.719 255.033 200.669 252.179 201.033 248.939L200.991 247.104C200.953 245.049 200.908 242.934 200.904 240.824C199.892 240.33 199.058 239.429 198.486 238.194C197.019 235.035 195.534 231.889 194.048 228.743C191.672 223.698 189.219 218.505 186.877 213.342C183.178 205.201 180.07 196.909 177.641 188.692C177.459 188.079 177.087 187.348 176.693 186.565C176.39 185.973 176.087 185.377 175.821 184.768C175.59 184.239 175.348 183.707 175.101 183.178C174.317 181.474 173.513 179.732 172.949 177.77C172.437 176.002 172.444 174.315 172.448 172.822C172.452 172.424 172.452 172.039 172.444 171.659C172.426 171.067 172.516 170.445 172.702 169.845C171.721 168.809 171.004 167.857 170.462 166.872C168.594 163.464 166.892 159.983 165.247 156.617L164.182 154.439C164.148 154.363 164.11 154.287 164.072 154.211C163.996 154.968 163.913 155.763 163.86 156.177C162.757 165.337 161.127 172.23 158.599 178.408C159.751 179.034 160.604 180.235 160.93 181.728C161.715 185.364 162.473 189.183 163.254 193.399C163.507 194.778 163.17 196.338 162.363 197.56C163.621 200.309 164.36 203.231 164.917 205.747C165.698 209.24 166.327 212.792 166.937 216.226L167.191 217.655C167.442 219.072 167.066 220.26 166.884 220.831L166.854 220.932C166.816 221.609 166.57 226.049 166.467 227.622C168.256 228.552 169.469 230.489 169.818 233.005C170.364 236.904 170.959 241.518 171.228 246.127C171.607 252.5 171.736 257.672 171.641 262.395L171.622 263.419C171.463 271.187 171.3 279.221 170.557 287.167C169.898 294.28 168.908 301.439 167.949 308.357C167.544 311.288 167.153 314.126 166.782 316.959C166.661 317.898 166.483 318.786 166.327 319.572L166.206 320.177L164.292 332.034L164.303 332.292C164.334 334.834 164.489 337.358 164.656 340.035C164.804 342.403 164.951 344.822 165.012 347.245C165.073 349.867 164.781 352.379 164.497 354.802L164.428 355.368C164.284 356.595 163.913 357.644 163.614 358.485C163.507 358.781 163.42 359.031 163.344 359.28L163.284 359.483L163.617 360.244C165.524 364.566 166.903 367.691 168.579 374.208C168.836 375.21 169.105 376.195 169.374 377.172L169.412 377.299C170.284 380.47 171.19 383.748 171.512 387.08C171.777 389.816 171.717 395.081 171.546 397.292C171.459 398.396 171.254 399.47 170.936 400.485L170.944 402.058C170.966 406.173 169.837 409.915 168.844 413.222C168.677 413.776 168.518 414.292 168.37 414.804C165.505 424.657 163.356 434.916 161.283 444.832C160.328 449.382 160.165 453.141 160.767 456.66C161.116 458.694 161.309 460.694 161.499 462.627C161.556 463.219 161.616 463.811 161.677 464.398C161.764 465.219 161.677 465.908 161.62 466.365L161.586 466.737C166.676 466.306 169.708 466.322 171.577 466.83C175.674 467.934 179.403 471.507 180.858 475.719C182.253 479.761 181.507 484.045 178.812 487.47C176.242 490.744 173.005 491.72 170.151 492.583C168.124 493.196 166.373 493.729 165.285 494.985C164.879 495.454 164.455 496.093 164.008 496.77C163.492 497.543 162.973 498.33 162.34 499.1C159.725 502.28 153.27 503.121 150.223 503.121Z"
                                fill="#8D939F" />
                        </g>
                        <g class="skin" data-body-part="skin">
                            <g class="head-and-neck js-body-area" data-body-part="head-and-neck">
                                <path
                                    d="M100.408 43.9913C100.845 45.0193 101.273 46.0811 101.873 46.9822C102.135 47.3799 102.829 47.5787 103.319 47.5575H104.901C105.057 48.8648 105.201 50.1721 105.353 51.4793C105.614 53.7808 105.759 56.1035 106.001 58.4092C106.176 60.0676 107.246 60.8755 108.608 61.6412C108.696 61.0828 108.764 60.681 108.825 60.2791C109.189 57.7788 109.428 55.2446 109.952 52.7908C110.661 49.4698 111.697 46.208 114.274 44.0842C118.721 40.4163 123.472 40.2134 128.436 42.8363C131.001 44.1944 132.466 46.5761 133.365 49.3429C134.196 51.9025 134.64 54.6311 135.167 57.3049C135.437 58.684 135.513 60.1098 135.703 61.7344C136.924 60.9771 137.945 60.2367 138.161 58.8787C138.518 56.683 138.628 54.4407 138.913 52.2281C139.11 50.6797 139.3 49.123 139.501 47.5703L140.992 47.5788C141.508 47.3546 142.055 47.1853 142.529 46.8765C142.757 46.7326 142.867 46.335 143 46.0304C144.104 43.4412 145.204 40.8521 146.293 38.2587C146.419 37.9583 146.487 37.6241 146.544 37.421C146.574 36.2788 144.935 34.0958 143.998 34.045L141.505 32.886L141.497 32.9155C141.774 28.998 141.672 25.0677 140.897 21.1078C138.765 10.176 129.73 2.83592 119.924 4.2024C115.913 4.76507 112.308 6.4446 109.337 9.57947C104.666 14.5081 102.909 20.8159 102.67 27.7541C102.605 29.6071 102.681 31.4474 102.84 33.2793L100.416 34.0494C98.9548 34.0917 97.5165 36.8415 98.1161 38.3434C98.8675 40.2302 99.6188 42.1214 100.408 43.9913Z"
                                    fill="#8D939F" />
                                <path
                                    d="M129.516 82.394L134.916 80.952C138.273 81.0701 141.636 81.0365 144.992 81.0955C145.163 81.0997 145.33 81.0112 145.785 80.8847C145.296 80.5516 145.034 80.3743 144.765 80.1972C142.717 78.8437 140.646 77.5324 138.625 76.1282C136.05 74.3404 134.833 71.6798 134.693 68.3234C134.571 65.4266 134.306 62.5297 134.2 59.6287C134.04 55.273 132.907 51.2629 130.954 47.5185C130.779 47.1896 130.517 46.9157 130.294 46.6163C130.169 46.6627 130.043 46.709 129.918 46.7596C130.358 52.4689 130.798 58.1783 131.238 63.9128C131.155 63.5544 131.037 63.2129 130.995 62.8587C130.316 57.356 129.672 51.849 128.951 46.3505C128.872 45.7433 128.504 44.959 128.052 44.6639C124.302 42.2309 120.464 42.1847 116.547 44.2803C115.39 44.9001 115.026 45.756 114.965 47.1391C114.689 53.3375 113.926 59.4684 112.485 65.4729C112.334 66.1011 112.08 66.6957 111.871 67.3071C113.213 58.5535 114.074 48.1173 113.335 46.5698C113.016 47.0463 112.686 47.4428 112.447 47.8982C110.976 50.7022 110.013 53.7086 109.751 56.947C109.421 61.0582 109.228 65.1819 108.841 69.2847C108.579 72.0423 107.681 74.5471 105.458 76.1325C103.547 77.4945 101.579 78.7511 99.6297 80.0498C99.2884 80.2775 98.9243 80.4756 98.3555 80.8171C98.8105 80.9563 99.0115 81.0786 99.2125 81.0786C102.777 81.0196 106.346 80.9648 109.91 80.8762L109.907 80.8847L114.586 82.4406C119.368 86.6234 121.31 92.2062 121.871 98.8516C122.713 95.4909 123.278 92.5225 124.207 89.7058C125.178 86.7752 127.139 84.5487 129.516 82.394Z"
                                    fill="#8D939F" />
                            </g>

                            <g class="upper-extremity js-body-area" data-body-part="upper-extremity">
                                <path
                                    d="M237.803 252.144C234.731 250.619 231.678 249.077 229.661 245.964C228.994 244.933 228.244 243.966 227.52 242.977C225.443 240.139 223.099 237.638 219.943 236.173C219.484 235.961 218.982 235.856 218.5 235.699L213.765 235.222C213.765 235.222 213.78 235.256 213.807 235.311C213.049 235.252 212.273 235.353 211.511 235.678C209.385 236.582 207.335 237.719 205.292 238.838C204.945 239.028 204.594 239.666 204.594 240.101C204.587 243.176 204.67 246.251 204.722 249.326C204.338 252.004 205.54 254.581 206.4 257.06C207.274 259.578 208.138 261.8 209.544 263.654C209.634 263.954 209.694 264.178 209.792 264.38C210.818 266.543 211.813 268.731 212.91 270.852C213.743 272.453 214.647 274.028 215.669 275.485C215.963 275.899 216.875 276.132 217.35 275.95C218.112 275.658 217.787 274.818 217.531 274.21C216.679 272.182 215.695 270.218 214.953 268.144C214.828 267.802 214.681 267.489 214.519 267.198C214.87 266.957 215.25 266.556 215.658 265.914C216.102 266.974 216.566 268.026 217.003 269.09C218.145 271.895 219.284 274.7 220.407 277.513C221.022 279.055 221.84 280.305 223.532 280.406C224.478 280.461 224.968 279.942 224.949 278.717C224.878 278.497 224.772 278.092 224.618 277.711C223.283 274.404 221.983 271.075 220.577 267.806C219.977 266.416 219.303 265.069 218.609 263.734C218.835 263.438 219.099 263.134 219.386 262.826C219.974 264.085 220.565 265.344 221.131 266.619C222.808 270.395 224.418 274.214 226.163 277.952C226.57 278.822 227.339 279.591 228.108 280.102C228.527 280.381 229.499 280.267 229.842 279.895C230.283 279.422 230.411 278.522 230.524 277.779C230.577 277.42 230.325 276.976 230.155 276.605C227.599 270.961 225.047 265.314 222.458 259.688C222.68 259.43 222.88 259.172 223.046 258.919C225.39 263.531 227.739 268.144 230.129 272.727C230.385 273.221 231.267 273.804 231.591 273.652C232.085 273.42 232.349 272.575 232.703 272.009C232.228 270.556 231.927 269.28 231.406 268.123C230 264.993 228.5 261.914 227.038 258.817C226.269 257.187 225.5 255.561 224.708 253.943C224.685 253.82 224.648 253.685 224.595 253.546C225.055 252.515 226.046 252.186 226.046 252.186C226.491 253.001 227.309 253.829 228.123 254.129C230.125 254.855 232.213 255.328 234.286 255.814C235.922 256.203 237.287 255.641 238.278 254.167C239.002 253.094 238.908 252.688 237.803 252.144Z"
                                    fill="#8D939F" />
                                <path
                                    d="M187.411 145.27C186.17 145.156 184.883 144.774 183.808 144.223C181.915 143.256 180.166 142.066 178.114 140.822C178.148 141.326 178.182 141.616 178.182 141.906C178.179 144.126 178.36 146.359 178.107 148.562C177.8 151.202 176.714 153.594 173.852 155.058C173.806 155.083 173.768 155.142 173.727 155.196C173.553 155.213 173.231 155.209 172.625 155.146C171.444 155.028 169.877 153.54 169.01 152.615C168.802 152.379 168.594 152.148 168.382 151.913C168.37 151.9 168.359 151.887 168.359 151.887L168.367 151.896C167.78 151.253 167.189 150.609 166.625 149.954C166.504 150.021 166.387 150.084 166.266 150.147C166.334 150.374 166.364 150.614 166.47 150.828C168.775 155.449 170.956 160.107 173.462 164.656C174.344 166.254 175.945 167.624 177.391 168.974C177.819 169.378 178.845 169.369 179.598 169.55L183.187 169.844C183.588 169.92 184.046 169.832 184.58 169.617C186.117 169.004 187.699 168.406 189.327 168.066C190.413 167.835 190.909 167.414 191 166.536C191.261 163.925 191.727 161.305 191.685 158.707C191.625 154.637 191.004 150.618 189.49 146.758C189.141 145.863 188.627 145.375 187.411 145.27Z"
                                    fill="#8D939F" />
                                <path
                                    d="M192.501 172.935C196.262 177.254 199.647 181.853 202.461 186.872C202.619 187.152 202.89 187.37 203.106 187.617C203.226 187.546 203.342 187.471 203.462 187.399C203.315 177.861 198.778 169.99 194.044 162.199C193.881 162.203 193.723 162.207 193.564 162.211C193.371 162.643 193.085 163.058 193 163.514C192.559 165.805 192.185 168.109 191.756 170.405C191.57 171.394 191.848 172.185 192.501 172.935Z"
                                    fill="#8D939F" />
                                <path
                                    d="M175.839 150.787C175.904 150.566 175.968 150.341 175.991 150.111C176.196 147.908 176.39 145.705 176.526 144.174C176.223 142.052 175.976 140.64 175.82 139.215C174.954 131.314 170.653 125.126 166.339 118.968C165.982 118.453 164.995 118.155 164.342 118.224C163.978 118.258 163.659 119.227 163.401 119.814C163.26 120.137 163.249 120.541 163.252 120.907C163.271 125.717 163.18 130.535 163.363 135.341C163.613 141.95 166.461 147.453 170.751 152.169C173.026 154.674 174.871 154.092 175.839 150.787Z"
                                    fill="#8D939F" />
                                <path
                                    d="M174.663 122.073C173.387 121.78 172.119 121.457 170.438 121.046C170.748 122.019 170.87 122.61 171.119 123.16C172.545 126.243 174.177 129.259 175.395 132.41C177.165 136.978 180.77 140.141 184.666 143.115C186.88 144.801 188.888 144.13 189.558 141.58C189.711 140.992 189.849 140.359 189.761 139.772C189.397 137.284 189.171 134.746 188.466 132.334C187.604 129.36 186.344 126.482 185.195 123.583C184.88 122.791 184.39 122.107 183.168 122.409C180.299 123.126 177.467 122.715 174.663 122.073Z"
                                    fill="#8D939F" />
                                <path
                                    d="M215.623 233.872C216.733 234.117 216.952 233.559 216.548 232.328C214.344 225.6 212.086 218.893 209.98 212.127C208.976 208.9 208.285 205.559 207.413 202.277C207.311 201.884 206.975 201.559 206.745 201.203C206.45 201.55 206.095 201.855 205.884 202.252C205.722 202.565 205.706 202.988 205.684 203.364C205.559 205.597 205.352 207.834 205.367 210.071C205.401 214.334 205.563 218.597 205.672 222.859C205.537 222.864 205.401 222.868 205.261 222.872C204.132 215.996 203.894 209.039 204.14 202.091C204.385 195.203 203.177 188.906 199.089 183.446C198.821 183.087 198.553 182.723 198.277 182.368V182.364C198.138 182.186 197.998 182.013 197.854 181.844L194.77 178.021C193.415 176.942 192.207 175.961 190.976 175.018L188.632 172.557C188.564 172.443 188.477 172.35 188.368 172.278L188.345 172.252V172.256C188.036 172.07 187.583 172.045 186.982 172.206C185.952 172.485 184.985 173.145 184.061 173.758C183.034 174.439 182.83 175.526 183.321 176.646C183.849 177.864 184.434 179.069 185.144 180.169C186.469 182.22 187.821 184.203 188.515 186.652C190.931 195.177 193.441 203.669 195.907 212.177C196.628 214.66 197.311 217.155 198.009 219.645C197.949 219.667 197.888 219.688 197.828 219.709C197.76 219.569 197.673 219.434 197.628 219.282C195.08 210.668 192.569 202.045 189.984 193.448C188.764 189.396 187.692 185.26 185.22 181.788C183.717 179.674 182.245 177.534 180.727 175.432C179.67 173.965 178.572 172.527 177.451 171.115C177.251 170.861 176.813 170.607 176.567 170.679C176.356 170.742 176.129 171.271 176.137 171.588C176.186 173.259 176.016 175.022 176.465 176.578C177.111 178.811 178.202 180.9 179.134 183.036C179.787 184.525 180.674 185.924 181.131 187.472C183.57 195.748 186.597 203.766 190.123 211.56C193.883 219.878 197.836 228.095 201.671 236.375C202.158 237.428 202.732 237.382 203.566 236.954C207.375 234.996 211.127 232.869 215.623 233.872Z"
                                    fill="#8D939F" />
                                <path
                                    d="M37.6953 238.838C35.6515 237.719 33.6037 236.582 31.4789 235.678C30.7148 235.357 29.9388 235.252 29.1834 235.311C29.2086 235.256 29.2233 235.222 29.2233 235.222L24.4879 235.699C24.0066 235.856 23.5045 235.961 23.0465 236.173C19.8927 237.638 17.5456 240.139 15.4709 242.977C14.7465 243.966 13.9956 244.933 13.3273 245.964C11.31 249.077 8.25946 250.619 5.18633 252.144C4.08229 252.688 3.98654 253.094 4.71063 254.167C5.70159 255.641 7.06798 256.203 8.70236 255.814C10.774 255.328 12.8648 254.855 14.8645 254.129C15.6817 253.829 16.4988 253.001 16.9451 252.186C16.9451 252.186 17.9331 252.515 18.3922 253.546C18.3424 253.685 18.304 253.82 18.2791 253.943C17.4883 255.561 16.7227 257.187 15.9527 258.817C14.4875 261.914 12.99 264.993 11.584 268.123C11.0642 269.28 10.7623 270.556 10.2866 272.009C10.6402 272.575 10.9037 273.42 11.3986 273.652C11.7239 273.804 12.6044 273.221 12.8618 272.727C15.2516 268.144 17.6002 263.531 19.9429 258.919C20.1106 259.172 20.3107 259.43 20.5301 259.688C17.9417 265.314 15.3903 270.961 12.8339 276.605C12.6647 276.976 12.4114 277.42 12.466 277.779C12.5791 278.522 12.7073 279.422 13.146 279.895C13.4894 280.267 14.4638 280.381 14.8822 280.102C15.6477 279.591 16.4178 278.822 16.8241 277.952C18.5735 274.214 20.1811 270.395 21.8584 266.619C22.4238 265.344 23.0141 264.085 23.6033 262.826C23.8916 263.134 24.1551 263.438 24.3805 263.734C23.6854 265.069 23.0096 266.416 22.4133 267.806C21.0073 271.075 19.7073 274.404 18.3703 277.711C18.2173 278.092 18.111 278.497 18.0405 278.717C18.0198 279.942 18.5116 280.461 19.4581 280.406C21.1487 280.305 21.9674 279.055 22.5829 277.513C23.7062 274.7 24.843 271.895 25.987 269.09C26.4212 268.026 26.8878 266.974 27.3296 265.914C27.739 266.556 28.1204 266.957 28.4695 267.198C28.3089 267.489 28.16 267.802 28.0364 268.144C27.2931 270.218 26.3093 272.182 25.4582 274.21C25.2037 274.818 24.8781 275.658 25.6395 275.95C26.1121 276.132 27.0266 275.899 27.3179 275.485C28.3428 274.028 29.2452 272.453 30.0771 270.852C31.177 268.731 32.1694 266.543 33.1973 264.38C33.2931 264.178 33.3564 263.954 33.4446 263.654C34.8494 261.8 35.7149 259.578 36.5897 257.06C37.4495 254.581 38.6523 252.004 38.2652 249.326C38.3199 246.251 38.402 243.176 38.3949 240.101C38.3934 239.666 38.0413 239.028 37.6953 238.838Z"
                                    fill="#8D939F" />
                                <path
                                    d="M40.8749 186.872C43.5983 181.853 46.8734 177.254 50.5143 172.935C51.1467 172.185 51.4141 171.394 51.2346 170.405C50.8194 168.109 50.457 165.805 50.0307 163.514C49.9458 163.058 49.6713 162.643 49.4843 162.211C49.3309 162.207 49.1761 162.203 49.0213 162.199C44.4383 169.99 40.048 177.861 39.9062 187.399C40.0203 187.471 40.1359 187.546 40.2496 187.617C40.4616 187.37 40.723 187.152 40.8749 186.872Z"
                                    fill="#8D939F" />
                                <path
                                    d="M66.8572 171.588C66.8662 171.271 66.639 170.742 66.4283 170.679C66.1803 170.607 65.7424 170.861 65.5434 171.115C64.4226 172.527 63.3256 173.965 62.2652 175.432C60.7479 177.534 59.2761 179.674 57.7736 181.788C55.3035 185.26 54.2299 189.396 53.012 193.448C50.4238 202.045 47.9127 210.668 45.366 219.282C45.3218 219.434 45.2346 219.569 45.1667 219.709L44.9839 219.645C45.6842 217.155 46.3686 214.66 47.0867 212.177C49.5526 203.669 52.0607 195.177 54.479 186.652C55.1752 184.203 56.5259 182.22 57.8487 180.169C58.5595 179.069 59.1451 177.864 59.6743 176.646C60.1639 175.526 59.959 174.439 58.934 173.758C58.0095 173.145 57.0435 172.485 56.0113 172.206C55.4096 172.045 54.9585 172.07 54.65 172.256L54.6489 172.252L54.6267 172.278C54.5176 172.35 54.4304 172.443 54.3613 172.557L52.0196 175.018C50.7881 175.961 49.5805 176.942 48.2222 178.021L45.1417 181.839C44.711 182.355 44.3086 182.905 43.9062 183.446C39.817 188.906 38.6105 195.203 38.854 202.091C39.1001 209.039 38.8596 215.996 37.7316 222.872C37.5946 222.868 37.4575 222.864 37.3186 222.859C37.4292 218.597 37.5946 214.334 37.6255 210.071C37.6433 207.834 37.4323 205.597 37.3099 203.364C37.2892 202.988 37.273 202.565 37.108 202.252C36.9 201.855 36.5417 201.55 36.248 201.203C36.0196 201.559 35.6833 201.884 35.5802 202.277C34.7085 205.559 34.0169 208.9 33.0128 212.127C30.9085 218.893 28.6491 225.6 26.4464 232.328C26.0421 233.559 26.2603 234.117 27.3709 233.872C31.8655 232.869 35.6183 234.996 39.4259 236.954C40.262 237.382 40.8359 237.428 41.324 236.375C45.1595 228.095 49.1101 219.878 52.872 211.56C56.396 203.766 59.4236 195.748 61.8612 187.472C62.3184 185.924 63.2089 184.525 63.8579 183.036C64.7914 180.9 65.884 178.811 66.5284 176.578C66.9769 175.022 66.81 173.259 66.8572 171.588Z"
                                    fill="#8D939F" />
                                <path
                                    d="M79.7501 120.907C79.7501 120.541 79.7427 120.137 79.6063 119.814C79.3555 119.227 79.0458 118.258 78.6881 118.224C78.0575 118.155 77.0987 118.453 76.7521 118.968C72.5594 125.126 68.384 131.314 67.5428 139.215C67.3913 140.64 67.1538 142.052 66.8555 144.174C66.9897 145.705 67.1781 147.908 67.3769 150.111C67.3986 150.341 67.4621 150.566 67.524 150.787C68.4647 154.092 70.2565 154.674 72.4672 152.169C76.6341 147.453 79.3998 141.95 79.6431 135.341C79.8201 130.535 79.7316 125.717 79.7501 120.907Z"
                                    fill="#8D939F" />
                                <path
                                    d="M53.6672 168.066C55.2953 168.406 56.8741 169.004 58.4136 169.617C58.9443 169.832 59.4057 169.92 59.8066 169.844L63.392 169.55C64.1446 169.369 65.1723 169.378 65.6011 168.974C67.0486 167.624 68.6502 166.254 69.5284 164.656C72.0361 160.107 74.2172 155.449 76.5187 150.828C76.6285 150.614 76.6587 150.374 76.7269 150.147C76.6057 150.084 76.4846 150.021 76.3673 149.954C75.8033 150.609 75.2128 151.253 74.626 151.896L74.6298 151.887C74.6298 151.887 74.6185 151.9 74.6071 151.913C74.3989 152.148 74.1907 152.379 73.9825 152.615C73.1119 153.54 71.5452 155.028 70.3683 155.146C69.7604 155.209 69.4383 155.213 69.2638 155.196C69.2237 155.142 69.1839 155.083 69.1381 155.058C66.2768 153.594 65.1901 151.202 64.8857 148.562C64.6313 146.359 64.813 144.126 64.8085 141.906C64.807 141.616 64.8441 141.326 64.8782 140.822C62.8258 142.066 61.0781 143.256 59.1839 144.223C58.1089 144.774 56.8211 145.156 55.5818 145.27C54.3664 145.375 53.8535 145.863 53.5014 146.758C51.9888 150.618 51.3692 154.637 51.3071 158.707C51.2673 161.305 51.7303 163.925 51.9934 166.536C52.082 167.414 52.579 167.835 53.6672 168.066Z"
                                    fill="#8D939F" />
                                <path
                                    d="M58.5972 143.115C62.4181 140.141 65.9529 136.978 67.6872 132.41C68.8828 129.259 70.4838 126.243 71.8792 123.16C72.1253 122.61 72.2455 122.019 72.546 121.046C70.8992 121.457 69.6577 121.78 68.4061 122.073C65.6535 122.715 62.8786 123.126 60.0674 122.409C58.8699 122.107 58.3857 122.791 58.0792 123.583C56.9538 126.482 55.7168 129.36 54.8701 132.334C54.1819 134.746 53.9588 137.284 53.6008 139.772C53.5156 140.359 53.6493 140.992 53.8018 141.58C54.4607 144.13 56.4252 144.801 58.5972 143.115Z"
                                    fill="#8D939F" />
                            </g>
                            <g class="back js-body-area" data-body-part="back">
                                <path
                                    d="M117.356 89.6104C116.098 86.2526 114.152 83.6869 110.584 83.0886C106.213 82.3556 101.831 81.9301 97.4828 82.7895C93.9377 83.4889 90.4721 84.6811 86.9686 85.6543C86.9686 85.8355 86.9686 86.0208 86.9648 86.2019C92.1234 87.9082 94.1687 92.4248 95.3883 97.649C95.8541 99.6417 96.1837 101.676 96.5927 103.686C97.4487 107.929 98.2744 112.226 100.456 115.891C103.982 121.823 107.637 127.663 111.368 133.43C114.712 138.6 118.17 143.668 119.897 149.857C120.257 151.155 120.492 152.494 120.852 154.129C120.954 151.972 121.128 150.135 121.113 148.302C121.007 134.454 120.825 120.602 120.753 106.753C120.723 100.745 119.401 95.0832 117.356 89.6104Z"
                                    fill="#8D939F" />
                                <path
                                    d="M135.083 82.7004C131.841 83.0722 129.011 84.1792 127.335 87.5721C125.394 91.4973 124.047 95.7648 123.615 100.134C122.961 106.789 122.802 113.52 122.704 120.225C122.56 129.854 122.654 139.488 122.669 149.117C122.673 150.651 122.806 152.185 122.874 153.719C124.164 145.771 128.375 139.611 132.495 133.387C135.057 129.516 137.618 125.642 140.096 121.704C142.692 117.58 145.03 113.279 146.135 108.314C146.979 104.507 147.667 100.653 148.568 96.8592C149.464 93.0649 150.997 89.6467 154.133 87.4918C154.951 86.9298 155.87 86.5538 156.744 86.0932C156.755 85.9707 156.763 85.8524 156.774 85.7299C154.054 84.8722 151.36 83.9089 148.613 83.1906C144.145 82.0202 139.62 82.1807 135.083 82.7004Z"
                                    fill="#8D939F" />
                                <path
                                    d="M162.588 127.151L162.414 122.295L162.402 122.3C162.383 121.991 162.323 121.654 162.22 121.252C161.925 120.121 161.584 119.002 161.22 117.896C159.309 112.052 156.053 107.344 151.5 103.768C149.541 102.227 148.604 102.695 148.18 105.284C147.543 109.164 146.58 112.956 144.798 116.363C143.24 119.34 141.364 122.11 139.628 124.968L137.118 129.528C134.302 134.329 131.47 139.121 128.665 143.93C127.702 145.586 127.687 147.253 128.764 148.883C132.005 153.79 135.799 158.041 140.507 161.217C144.04 163.602 147.649 163.497 151.246 161.512C155.124 159.376 157.55 155.685 159.449 151.505C162.065 145.759 162.816 139.569 162.857 132.235C162.804 131.192 162.721 129.169 162.588 127.151Z"
                                    fill="#8D939F" />
                                <path
                                    d="M114.164 150.024C116.18 147.241 116.331 146.105 114.618 143.094C112.046 138.58 109.338 134.158 106.718 129.673L104.675 125.788L104.509 125.763C104.399 125.48 104.244 125.172 104.017 124.817C102.705 122.756 101.306 120.759 100.092 118.63C97.6598 114.378 96.234 109.69 95.47 104.728C95.1788 102.861 94.2825 102.422 92.8038 103.377C92.1873 103.778 91.5973 104.247 91.0376 104.749C86.3102 108.981 83.2959 114.458 81.6357 120.923C81.4957 121.468 81.4163 121.907 81.3937 122.287H81.3899L81.2046 127.228C81.0798 129.162 80.9927 131.097 80.8906 133.052C80.9814 134.889 81.0306 136.747 81.1705 138.593C81.6697 145.079 83.5115 151.034 87.0023 156.283C89.1428 159.505 91.9642 161.709 95.4549 162.689C98.8624 163.639 101.865 162.326 104.649 160.248C108.363 157.478 111.373 153.876 114.164 150.024Z"
                                    fill="#8D939F" />
                                <path
                                    d="M160.579 151.813C160.466 151.779 160.352 151.745 160.242 151.712C160.072 152.104 159.92 152.509 159.727 152.885C158.587 155.117 157.549 157.425 156.261 159.543C154.935 161.716 153.31 163.665 150.893 164.361C147.605 165.311 144.367 165.045 141.219 163.585C140.942 163.458 140.647 163.387 140.09 163.192C143.965 171.036 145.897 179.235 147.336 188.023C148.166 187.391 148.761 187.036 149.249 186.551C151.689 184.116 153.359 181.066 154.769 177.821C157.799 170.83 159.25 163.357 160.174 155.728C160.333 154.425 160.447 153.117 160.579 151.813Z"
                                    fill="#8D939F" />
                                <path
                                    d="M103.29 163.201C102.933 163.293 102.787 163.306 102.659 163.365C100.457 164.449 98.1456 164.946 95.7593 164.799C93.1591 164.639 90.589 164.107 88.9343 161.59C87.2083 158.962 85.6925 156.154 84.1166 153.4C83.8277 152.898 83.7001 152.278 83.4938 151.709C83.4037 151.734 83.3099 151.755 83.2161 151.776C83.2049 151.979 83.1598 152.181 83.1898 152.375C84.1053 158.684 84.7019 165.043 86.5855 171.154C87.985 175.687 89.6359 180.031 92.2248 183.86C92.9903 184.986 93.917 186.003 94.8738 186.939C95.9732 188.014 96.3221 187.829 96.5848 186.256C96.6035 186.129 96.6185 186.007 96.6373 185.88C97.6616 179.609 99.0912 173.474 101.444 167.645C102.022 166.216 102.626 164.799 103.29 163.201Z"
                                    fill="#8D939F" />
                                <path
                                    d="M99.0633 191.336C98.9353 191.154 98.7696 190.989 98.57 190.836L98.5587 190.827L98.5549 190.832C98.3026 190.637 98.0239 190.458 97.7829 190.289C97.5306 190.111 97.1653 190.14 96.6419 190.034C92.3752 190.335 88.7901 192.604 86.1088 196.599C84.1393 199.538 83.1639 203.075 82.3844 206.621C81.5258 210.505 80.8592 214.445 80.1625 218.376C80.0834 218.839 80.3583 219.386 80.4676 219.891C80.9157 219.691 81.5295 219.636 81.7819 219.263C82.7045 217.902 83.6535 216.515 84.3313 214.988C84.5535 214.483 84.787 213.987 85.0167 213.491L88.888 209.135L91.0872 207.558C91.8366 207.066 92.6011 206.612 93.4146 206.311C96.4235 205.187 99.5416 204.39 102.633 203.546C103.925 203.194 104.271 202.986 103.929 201.578C103.375 199.314 102.679 197.087 101.94 194.882C101.733 194.258 101.485 193.838 101.191 193.618L101.214 193.508L99.0633 191.336Z"
                                    fill="#8D939F" />
                                <path
                                    d="M141.119 203.546C144.215 204.39 147.333 205.187 150.343 206.311C151.152 206.612 151.917 207.066 152.67 207.558L154.87 209.135L158.741 213.487C158.971 213.987 159.205 214.483 159.427 214.988C160.105 216.515 161.05 217.902 161.973 219.263C162.225 219.636 162.843 219.691 163.291 219.891C163.4 219.386 163.675 218.839 163.592 218.376C162.899 214.445 162.229 210.505 161.374 206.621C160.591 203.075 159.619 199.538 157.645 196.599C154.968 192.604 151.382 190.335 147.115 190.034C146.591 190.14 146.222 190.111 145.974 190.289C145.733 190.458 145.454 190.637 145.198 190.832V190.827L145.187 190.836C144.987 190.989 144.818 191.154 144.693 191.336L142.543 193.508L142.565 193.618C142.268 193.838 142.023 194.258 141.812 194.882C141.074 197.087 140.377 199.314 139.827 201.578C139.485 202.986 139.831 203.194 141.119 203.546Z"
                                    fill="#8D939F" />
                                <path
                                    d="M85.6594 194.771C86.4482 193.956 87.0604 192.939 87.898 192.195C89.2726 190.969 90.7713 189.903 92.2812 188.719C90.7788 186.686 89.2839 184.616 87.7402 182.579C87.1054 181.742 86.4106 181.759 86.2228 182.625C85.404 186.418 84.6528 190.225 83.9429 194.039C83.8753 194.412 84.1871 195.114 84.4838 195.248C84.773 195.374 85.3702 195.072 85.6594 194.771Z"
                                    fill="#8D939F" />
                                <path
                                    d="M156.023 182.579C154.479 184.616 152.98 186.686 151.48 188.719C152.991 189.903 154.49 190.969 155.865 192.195C156.703 192.939 157.315 193.956 158.104 194.771C158.394 195.072 158.991 195.374 159.277 195.248C159.577 195.114 159.889 194.412 159.818 194.039C159.111 190.225 158.36 186.418 157.541 182.625C157.353 181.759 156.654 181.742 156.023 182.579Z"
                                    fill="#8D939F" />
                            </g>
                            <g class="torso internal-organs back js-body-area" data-body-part="internal-organs">
                                <path
                                    d="M122.753 220.15C122.746 223.311 122.648 226.472 122.625 229.633C122.621 230.013 122.821 230.401 122.926 230.785C123.25 230.557 123.683 230.409 123.879 230.084C124.989 228.236 126.122 226.387 127.109 224.454C130.049 218.698 131.607 212.333 133.474 206.1C134.769 201.786 136.011 197.427 138.281 193.594C139.573 191.417 140.916 189.26 143.367 188.471C145.069 187.922 145.091 187.876 144.967 185.862C144.485 178.173 142.595 170.918 138.473 164.739C135.356 160.067 131.626 155.906 128.151 151.538C127.861 151.175 127.432 150.926 127.037 150.702C126.359 150.322 125.697 150.44 125.452 151.28C124.605 154.192 123.431 157.079 123.133 160.071C122.7 164.452 122.877 168.909 122.862 173.336C122.832 181.689 122.855 190.037 122.855 198.389C122.821 198.389 122.791 198.389 122.761 198.389C122.761 205.644 122.776 212.899 122.753 220.15Z"
                                    fill="#8D939F" />
                                <path
                                    d="M120.992 165.725C120.852 165.725 120.856 160.958 120.502 158.672C120.137 156.293 119.195 154.024 118.437 151.734C117.993 150.384 117.341 150.169 116.268 150.937C115.827 151.253 115.427 151.662 115.077 152.097C113.604 153.898 112.15 155.72 110.707 157.546C109.136 159.533 107.539 161.494 106.028 163.531C103.937 166.349 102.592 169.639 101.36 173.009C99.7555 177.391 98.9607 181.938 98.7346 186.645C98.6894 187.632 99.0096 188.134 99.8535 188.328C101.553 188.72 102.826 189.826 103.93 191.293C106.887 195.229 108.341 199.969 109.799 204.723C111.234 209.384 112.579 214.082 114.147 218.688C115.544 222.792 117.432 226.643 119.854 230.127C120.061 230.422 120.434 230.57 120.732 230.785C120.867 230.422 121.108 230.06 121.116 229.693C121.131 228.811 120.995 227.93 120.995 227.048C120.988 206.604 120.992 186.164 120.992 165.725Z"
                                    fill="#8D939F" />
                            </g>
                            <g class="lower-extremity js-body-area" data-body-part="lower-extremity">
                                <path
                                    d="M88.5874 247.177C88.4626 243.023 87.9486 238.949 85.7188 235.292C84.6794 233.583 83.3415 232.181 81.4064 231.518C79.0896 230.724 77.7253 231.366 77.3927 233.751C76.8031 237.977 76.274 242.229 76.0207 246.493C75.7108 251.775 75.5105 257.081 75.6201 262.38C75.7864 270.515 75.9263 278.676 76.6784 286.782C77.6005 296.666 79.1388 306.503 80.4238 316.356C80.5561 317.361 80.7753 318.353 80.968 319.35L82.9409 331.585C82.9371 331.825 82.9409 332.062 82.9371 332.302C82.8767 337.305 82.3475 342.291 82.2304 347.29C82.1699 349.773 82.4949 352.285 82.7822 354.767C82.9031 355.827 83.3831 356.848 83.7006 357.883C83.8291 357.866 83.9575 357.849 84.086 357.828C84.1919 357.613 84.3091 357.401 84.3998 357.178C86.1081 352.871 87.6123 348.468 89.5662 344.288C93.3683 336.144 95.2807 327.574 95.6133 318.569C95.8741 311.493 96.1236 304.421 96.4372 297.35C96.5355 295.192 96.887 293.056 97.0268 290.899C97.3783 285.444 97.7789 279.989 97.9528 274.526C98.0511 271.402 97.8281 268.253 97.5824 265.128C97.4501 263.461 96.8492 263.06 95.2921 263.562C94.2943 263.883 93.3155 264.259 92.3441 264.655C90.6358 265.285 86.5427 266.479 86.4935 263.638C87.7332 258.234 88.7499 252.792 88.5874 247.177Z"
                                    fill="#8D939F" />
                                <path
                                    d="M94.5512 357.066C95.0798 356.618 95.4514 356.324 95.7962 356.003C96.8266 355.047 97.7843 353.997 98.8837 353.147C99.9563 352.319 100.159 351.866 99.4392 350.654C97.5123 347.392 95.9341 343.968 95.0837 340.211C95.0415 340.023 94.9189 339.852 94.6699 339.314C93.4824 341.799 92.4251 344.019 91.364 346.239C90.935 347.136 91.1725 347.896 91.5863 348.771C92.4099 350.521 93.0917 352.349 93.7697 354.172C94.0877 355.03 94.2524 355.948 94.5512 357.066Z"
                                    fill="#8D939F" />
                                <path
                                    d="M106.318 206.581C105.809 204.534 104.844 203.927 102.675 204.232C98.1082 204.886 94.3181 206.976 91.0899 209.987C86.2741 214.48 83.3438 220.074 81.1829 226.083C80.5606 227.812 80.8812 228.542 82.6386 229.481C85.5009 231.014 87.3526 233.299 88.2464 236.263C89.5814 240.714 90.3206 245.254 90.1169 249.862C89.9698 253.217 89.506 256.555 89.1817 259.906C88.8385 262.242 89.9699 263.134 92.2929 262.421C98.2666 260.59 103.927 258.127 109.071 254.708C113.789 251.569 117.813 247.849 120.234 242.71C121.513 240.005 121.46 237.779 119.631 235.129C113.544 226.321 108.864 216.88 106.318 206.581Z"
                                    fill="#8D939F" />
                                <path
                                    d="M89.8696 350.206C89.4638 350.219 88.9368 350.816 88.7131 351.291C87.5527 353.749 85.6682 356.407 84.595 358.911C81.9938 364.968 80.4922 367.689 78.5659 375.212C77.4738 379.458 76.1315 383.493 75.7485 387.431C75.5096 389.885 75.5741 394.924 75.722 396.869C76.086 401.548 79.0626 404.032 83.0403 405.214C86.0625 406.109 88.1291 404.727 88.3642 401.404C88.641 397.463 88.5576 393.487 88.8913 389.558C89.4411 383.04 90.1085 376.534 90.9085 370.05C91.4773 365.417 92.285 360.831 92.285 356.127C92.2812 354.343 91.8414 352.757 91.0564 351.253C90.81 350.787 90.2601 350.197 89.8696 350.206Z"
                                    fill="#8D939F" />
                                <path
                                    d="M116.87 254.32C116.881 254.126 116.889 253.936 116.87 253.742C116.772 252.665 115.634 252.171 114.928 252.956C113.035 255.076 110.514 256.212 108.005 257.285C103.853 259.067 101.937 262.425 101.34 266.598C100.66 271.37 100.248 276.189 99.8323 281.004C99.3373 286.705 98.9103 292.415 98.5551 298.129C98.2415 303.121 97.8372 308.122 97.8825 313.122C97.8863 313.583 97.9052 314.043 97.9165 314.503L97.909 314.533L96.1028 334.624C95.7401 335.891 95.5889 337.2 95.8232 338.556C96.6847 343.505 98.9708 347.834 102.149 351.699C103.139 352.902 103.717 354.089 103.683 355.618C103.66 356.691 103.762 357.763 103.811 358.84L103.906 370.252C104.132 370.294 104.355 370.336 104.582 370.383C105.02 369.534 105.421 368.677 105.897 367.84C110.102 356.927 110.851 351.04 113.061 341.571C114.965 333.416 116.568 323.888 116.87 317.747C117.422 306.644 117.52 291.482 118.094 280.383C118.173 278.829 116.885 259.604 116.855 258.037L116.87 254.32Z"
                                    fill="#8D939F" />
                                <path
                                    d="M101.98 368.605C101.991 366.389 102.055 362.672 102.168 360.46C102.247 358.892 102.243 357.316 102.186 355.743C102.149 354.807 101.532 354.383 100.626 354.815C99.6108 355.298 98.5279 355.773 97.7232 356.498C95.6175 358.413 94.4895 360.952 93.8503 363.588C92.1281 370.699 91.3122 377.958 90.7632 385.264C90.6316 389.176 90.3947 393.087 90.3985 397.007C90.4022 401.152 90.9137 405.275 92.2297 409.289C93.2487 412.391 94.8467 415.154 97.821 417.014C99.1032 417.815 100.306 417.794 101.378 416.828C102.01 416.256 103.649 413.921 104.01 413.213C105.841 409.606 106.631 406.598 106.887 403.907C107.439 398.079 106.875 392.596 105.315 386.866C103.288 379.441 101.942 376.95 101.98 368.605Z"
                                    fill="#8D939F" />
                                <path
                                    d="M97.1878 456.589C94.8954 455.636 90.2805 457.399 89.4749 459.921C89.0081 461.376 88.4548 462.806 87.8902 464.223L87.8676 464.21C86.2791 468.107 86.1285 468.242 84.2614 471.16C82.6127 471.013 75.4004 470.22 72.8633 470.907C70.0702 471.666 67.2414 474.18 66.1724 477.288C65.3634 479.646 65.5622 482.341 67.5455 484.871C71.1159 489.434 77.2261 487.992 80.8661 492.222C81.9502 493.483 82.7934 495.102 83.8549 496.401C85.5525 498.472 94.1238 500.323 98.3435 498.05C101.027 491.653 100.636 487.49 99.9659 481.126C100.339 478.043 100.7 474.956 101.016 471.864C101.344 468.672 101.686 465.458 100.978 462.249C100.44 459.811 99.5819 457.584 97.1878 456.589Z"
                                    fill="#8D939F" />
                                <path
                                    d="M94.0482 416.39C92.4025 414.721 91.4406 412.637 90.7944 410.362C90.6291 409.792 90.4901 409.441 89.7424 409.517C88.5776 409.635 87.3677 409.623 86.2142 409.42C84.9105 409.187 83.648 408.68 82.1075 408.219C82.7011 411.115 83.2459 413.757 83.7908 416.399C84.3431 419.104 84.918 421.801 85.4477 424.506C85.97 427.174 86.4772 429.845 86.9281 432.525C87.379 435.188 87.7547 437.864 88.1643 440.536C87.8712 440.417 87.8111 440.261 87.781 440.1C85.8911 429.693 83.648 419.379 80.9051 409.175C80.2326 406.668 78.0722 404.461 76.34 402.263C76.3212 406.309 77.6964 410.189 78.7184 413.727C81.5965 423.716 83.7119 433.891 85.8272 444.074C86.7628 448.58 87.1385 453.031 86.3683 457.588C85.9512 460.044 85.7634 462.546 85.5041 465.036C85.459 465.48 85.5605 465.949 85.598 466.406C85.7108 466.41 85.8272 466.41 85.9437 466.414C86.0263 465.936 86.1203 465.463 86.1992 464.981C86.6576 462.183 87.4692 459.553 89.2539 457.368C91.7037 454.367 95.7691 453.479 98.6434 455.339C99.1055 455.639 99.5263 456.011 100.229 456.552C100.082 455.732 100.034 455.204 99.8946 454.701C99.5113 453.314 99.0529 451.945 98.6885 450.55C97.8919 447.472 97.7792 442.514 98.3954 439.289C99.5902 433.062 100.109 428.708 101.349 422.49C101.721 420.617 102.096 418.745 102.521 416.619C99.1544 419.7 97.2043 419.595 94.0482 416.39Z"
                                    fill="#8D939F" />
                                <path
                                    d="M144.875 353.147C145.978 353.997 146.936 355.047 147.963 356.003C148.311 356.324 148.683 356.618 149.212 357.066C149.507 355.948 149.675 355.03 149.993 354.172C150.667 352.349 151.349 350.521 152.177 348.771C152.587 347.896 152.828 347.136 152.399 346.239C151.334 344.019 150.277 341.799 149.089 339.314C148.84 339.852 148.721 340.023 148.679 340.211C147.825 343.968 146.25 347.392 144.323 350.654C143.603 351.866 143.806 352.319 144.875 353.147Z"
                                    fill="#8D939F" />
                                <path
                                    d="M154.874 389.558C155.208 393.487 155.121 397.463 155.398 401.404C155.633 404.727 157.703 406.109 160.725 405.214C164.703 404.032 167.68 401.548 168.04 396.869C168.192 394.924 168.256 389.885 168.017 387.431C167.634 383.493 166.288 379.458 165.2 375.212C163.27 367.689 161.772 364.968 159.171 358.911C158.098 356.407 156.213 353.749 155.053 351.291C154.825 350.816 154.302 350.219 153.896 350.206C153.505 350.197 152.956 350.787 152.709 351.253C151.92 352.757 151.48 354.343 151.48 356.127C151.48 360.831 152.288 365.417 152.857 370.05C153.657 376.534 154.321 383.04 154.874 389.558Z"
                                    fill="#8D939F" />
                                <path
                                    d="M142.4 416.828C143.471 417.794 144.674 417.815 145.957 417.014C148.931 415.154 150.525 412.391 151.544 409.289C152.864 405.275 153.375 401.152 153.379 397.007C153.379 393.087 153.146 389.176 153.014 385.264C152.465 377.958 151.649 370.699 149.927 363.588C149.288 360.952 148.16 358.413 146.051 356.498C145.25 355.773 144.167 355.298 143.152 354.815C142.245 354.383 141.625 354.807 141.591 355.743C141.535 357.316 141.531 358.892 141.61 360.46C141.723 362.672 141.787 366.389 141.798 368.605C141.832 376.95 140.489 379.441 138.463 386.866C136.899 392.596 136.338 398.079 136.891 403.907C137.147 406.598 137.936 409.606 139.764 413.213C140.125 413.921 141.768 416.256 142.4 416.828Z"
                                    fill="#8D939F" />
                                <path
                                    d="M134.665 254.708C139.809 258.127 145.469 260.59 151.439 262.421C153.762 263.134 154.897 262.242 154.554 259.906C154.23 256.555 153.766 253.217 153.619 249.862C153.415 245.254 154.151 240.714 155.489 236.263C156.379 233.299 158.235 231.014 161.097 229.481C162.855 228.542 163.175 227.812 162.553 226.083C160.392 220.074 157.462 214.48 152.646 209.987C149.418 206.976 145.628 204.886 141.061 204.232C138.892 203.927 137.923 204.534 137.418 206.581C134.872 216.88 130.189 226.321 124.106 235.129C122.277 237.779 122.224 240.005 123.499 242.71C125.923 247.849 129.947 251.569 134.665 254.708Z"
                                    fill="#8D939F" />
                                <path
                                    d="M145.049 439.289C145.678 442.514 145.564 447.472 144.752 450.55C144.386 451.945 143.921 453.314 143.532 454.701C143.391 455.204 143.338 455.732 143.193 456.552C143.902 456.011 144.333 455.639 144.801 455.339C147.718 453.479 151.843 454.367 154.328 457.368C156.135 459.553 156.963 462.183 157.428 464.981C157.504 465.463 157.599 465.936 157.687 466.414C157.805 466.41 157.92 466.41 158.038 466.406C158.072 465.949 158.179 465.48 158.133 465.036C157.87 462.546 157.679 460.044 157.256 457.588C156.475 453.031 156.856 448.58 157.805 444.074C159.952 433.891 162.094 423.716 165.018 413.727C166.055 410.189 167.45 406.309 167.427 402.263C165.674 404.461 163.482 406.668 162.799 409.175C160.016 419.379 157.74 429.693 155.819 440.1C155.792 440.261 155.731 440.417 155.43 440.536C155.846 437.864 156.227 435.188 156.684 432.525C157.146 429.845 157.66 427.174 158.19 424.506C158.724 421.801 159.307 419.104 159.871 416.399C160.424 413.757 160.973 411.115 161.579 408.219C160.016 408.68 158.735 409.187 157.409 409.42C156.238 409.623 155.015 409.635 153.833 409.517C153.07 409.441 152.929 409.792 152.765 410.362C152.11 412.637 151.13 414.721 149.464 416.39C146.262 419.595 144.283 419.7 140.867 416.619C141.298 418.745 141.675 420.617 142.057 422.49C143.315 428.708 143.837 433.062 145.049 439.289Z"
                                    fill="#8D939F" />
                                <path
                                    d="M139.184 370.383C139.407 370.336 139.633 370.294 139.86 370.252L139.955 358.84C140 357.763 140.102 356.691 140.079 355.618C140.049 354.089 140.627 352.902 141.617 351.699C144.795 347.834 147.081 343.505 147.942 338.556C148.177 337.2 148.026 335.891 147.663 334.624L145.853 314.533L145.849 314.503C145.857 314.043 145.879 313.583 145.883 313.122C145.925 308.122 145.52 303.121 145.211 298.129C144.852 292.415 144.428 286.705 143.933 281.004C143.518 276.189 143.106 271.37 142.422 266.598C141.825 262.425 139.913 259.067 135.76 257.285C133.251 256.212 130.731 255.076 128.834 252.956C128.131 252.171 126.994 252.665 126.896 253.742C126.877 253.936 126.881 254.126 126.896 254.32L126.907 258.037C126.881 259.604 125.592 278.829 125.671 280.383C126.246 291.482 126.344 306.644 126.896 317.747C127.198 323.888 128.8 333.416 130.705 341.571C132.915 351.04 133.663 356.927 137.869 367.84C138.345 368.677 138.745 369.534 139.184 370.383Z"
                                    fill="#8D939F" />
                                <path
                                    d="M170.831 470.907C168.267 470.22 160.978 471.013 159.308 471.16C157.42 468.242 157.272 468.107 155.667 464.21L155.644 464.223C155.069 462.806 154.51 461.376 154.042 459.921C153.228 457.399 148.564 455.636 146.247 456.589C143.827 457.584 142.956 459.811 142.416 462.249C141.7 465.458 142.047 468.672 142.378 471.864C142.697 474.956 143.062 478.043 143.435 481.126C142.758 487.49 142.366 491.653 145.079 498.05C149.34 500.323 158.006 498.472 159.722 496.401C160.795 495.102 161.647 493.483 162.743 492.222C166.418 487.992 172.597 489.434 176.203 484.871C178.208 482.341 178.41 479.646 177.592 477.288C176.511 474.18 173.654 471.666 170.831 470.907Z"
                                    fill="#8D939F" />
                                <path
                                    d="M151.421 264.655C150.45 264.259 149.467 263.883 148.474 263.562C146.916 263.06 146.315 263.461 146.183 265.128C145.938 268.253 145.715 271.402 145.813 274.526C145.987 279.989 146.387 285.444 146.739 290.899C146.875 293.056 147.23 295.192 147.325 297.35C147.642 304.421 147.891 311.493 148.152 318.569C148.485 327.574 150.393 336.144 154.199 344.288C156.153 348.468 157.654 352.871 159.366 357.178C159.453 357.401 159.574 357.613 159.676 357.828C159.808 357.849 159.937 357.866 160.065 357.883C160.383 356.848 160.859 355.827 160.983 354.767C161.271 352.285 161.596 349.773 161.535 347.29C161.414 342.291 160.889 337.305 160.829 332.302C160.825 332.062 160.829 331.825 160.825 331.585L162.798 319.35C162.99 318.353 163.21 317.361 163.338 316.356C164.627 306.503 166.165 296.666 167.083 286.782C167.839 278.676 167.979 270.515 168.146 262.38C168.255 257.081 168.055 251.775 167.741 246.493C167.492 242.229 166.963 237.977 166.373 233.751C166.037 231.366 164.676 230.724 162.359 231.518C160.424 232.181 159.086 233.583 158.047 235.292C155.817 238.949 155.299 243.023 155.178 247.177C155.012 252.792 156.029 258.234 157.272 263.638C157.223 266.479 153.13 265.285 151.421 264.655Z"
                                    fill="#8D939F" />
                            </g>
                            <g class="shoulders js-body-area" data-body-part="upper-extremity">
                                <path
                                    d="M61.0159 120.648C62.2122 120.797 63.4085 120.958 64.0123 121.039C69.9036 121.141 74.5888 119.182 78.4884 115.25C81.5659 112.143 84.2813 108.577 87.3022 105.385C88.8484 103.744 90.6738 102.418 92.4388 101.062C93.1629 100.51 93.4646 99.9105 93.4118 98.9669C93.1214 93.9345 88.8371 88.0137 84.5378 86.8874C83.6967 86.6706 82.686 86.7046 81.8713 87.0106C76.0408 89.2251 70.7627 92.5149 66.5078 97.6196C63.1875 101.598 61.6521 106.558 60.8198 111.812C60.431 114.273 60.2941 116.785 60.0406 119.267C59.9565 120.1 60.2703 120.555 61.0159 120.648Z"
                                    fill="#8D939F" />
                                <path
                                    d="M149.581 98.9669C149.524 99.9105 149.833 100.51 150.565 101.062C152.35 102.418 154.193 103.744 155.76 105.385C158.812 108.577 161.558 112.143 164.675 115.25C168.619 119.182 173.356 121.141 179.314 121.039C179.925 120.958 181.134 120.797 182.347 120.648C183.098 120.555 183.415 120.1 183.331 119.267C183.075 116.785 182.938 114.273 182.545 111.812C181.702 106.558 180.15 101.598 176.789 97.6196C172.486 92.5149 167.15 89.2251 161.253 87.0106C160.429 86.7046 159.407 86.6706 158.556 86.8874C154.208 88.0137 149.875 93.9345 149.581 98.9669Z"
                                    fill="#8D939F" />
                            </g>

                        </g>
                    </svg>
                </div>

                <div class="injury-popup-wrap js-injury-popup-wrap popup-head-and-neck js-head-and-neck"
                    data-popup-id="head-and-neck">
                    <div class="injury-popup-title"> HEAD AND NECK </div>
                    <div class="injury-popup-list">

                        <div class="injury-popup-list-item">
                            <b>Components: </b> Skull, Face, Brain, Eyes, Nose, Mouth, Ears, Cheeks, Jaw, Cervical
                            spine.
                        </div>

                        <div class="injury-popup-list-item">
                            <b>Musculoskeletal: </b> Bones (Skull, Cervical spine), Muscles, and Connective Tissues
                            (Neck
                            muscles, tendons, ligaments).
                        </div>
                    </div>
                    <button type="button" class="injury-popup-btn js-injury-popup-button btn btn-primary"
                        data-target-id="head-and-neck" aria-label="Add injury to list">Add</button>
                </div>
                <div class="injury-popup-wrap js-injury-popup-wrap popup-upper-extremity js-upper-extremity"
                    data-popup-id="upper-extremity">
                    <div class="injury-popup-title"> UPPER EXTREMITY (Right, Left, or Both) </div>
                    <div class="injury-popup-list">

                        <div class="injury-popup-list-item">
                            <b>Components: </b> Shoulder, Arm (Humerus, Radius, Ulna), Elbow, Forearm, Wrist, Hand
                            (Carpals,
                            Metacarpals, Phalanges, Fingers).
                        </div>

                        <div class="injury-popup-list-item">
                            <b>Musculoskeletal: </b> Bones (Clavicle, Scapula, Humerus, Radius, Ulna, Carpals,
                            Metacarpals,
                            Phalanges), Muscles, and Connective Tissues (Muscles, tendons, and ligaments of the upper
                            limb).
                        </div>
                    </div>
                    <button type="button" class="injury-popup-btn js-injury-popup-button btn btn-primary"
                        data-target-id="upper-extremity" aria-label="Add injury to list">Add</button>
                </div>
                <div class="injury-popup-wrap js-injury-popup-wrap popup-torso js-torso" data-popup-id="torso-full">
                    <div class="injury-popup-title"> TORSO </div>
                    <div class="injury-popup-list">

                        <div class="injury-popup-list-item">
                            <b>Components: </b> Thorax (Chest, Ribcage, Sternum), Abdomen (Stomach, Liver, Spleen,
                            Pancreas,
                            Kidneys, Intestines), Pelvis (Hips, Reproductive Organs), Diaphragm.
                        </div>

                        <div class="injury-popup-list-item">
                            <b>Musculoskeletal: </b> Bones (Ribcage, Sternum, Pelvis), Muscles, and Connective Tissues
                            (Abdominal muscles, pelvic muscles, diaphragm).
                        </div>
                    </div>
                    <button type="button" class="injury-popup-btn js-injury-popup-button btn btn-primary"
                        data-target-id="torso-full" aria-label="Add injury to list">Add</button>
                </div>
                <div class="injury-popup-wrap js-injury-popup-wrap popup-back js-back" data-popup-id="back">
                    <div class="injury-popup-title"> BACK </div>
                    <div class="injury-popup-list">

                        <div class="injury-popup-list-item">
                            <b>Components: </b> Thoracic Spine, Lumbar Spine, Coccyx, Sacrum, Clavicle, Scapula.
                        </div>

                        <div class="injury-popup-list-item">
                            <b>Musculoskeletal: </b> Bones (Thoracic Spine, Lumbar Spine, Coccyx, Sacrum, Clavicle,
                            Scapula),
                            Muscles, and Connective Tissues (Muscles and ligaments supporting the back and spinal
                            column).
                        </div>
                    </div>
                    <button type="button" class="injury-popup-btn js-injury-popup-button btn btn-primary"
                        data-target-id="back" aria-label="Add injury to list">Add</button>
                </div>
                <div class="injury-popup-wrap js-injury-popup-wrap popup-lower-extremity js-lower-extremity"
                    data-popup-id="lower-extremity">
                    <div class="injury-popup-title"> LOWER EXTREMITY (Right, Left, or Both) </div>
                    <div class="injury-popup-list">

                        <div class="injury-popup-list-item">
                            <b>Components: </b> Hip, Thigh (Femur), Knee (Patella), Leg (Tibia, Fibula), Ankle, Foot
                            (Tarsals,
                            Metatarsals, Phalanges, Toes).
                        </div>

                        <div class="injury-popup-list-item">
                            <b>Musculoskeletal: </b> Bones (Femur, Patella, Tibia, Fibula, Tarsals, Metatarsals,
                            Phalanges),
                            Muscles, and Connective Tissues (Muscles, tendons, and ligaments of the lower limb).
                        </div>
                    </div>
                    <button type="button" class="injury-popup-btn js-injury-popup-button btn btn-primary"
                        data-target-id="lower-extremity" aria-label="Add injury to list">Add</button>
                </div>
                <div class="injury-popup-wrap js-injury-popup-wrap popup-internal-organs js-internal-organs"
                    data-popup-id="internal-organs">
                    <div class="injury-popup-title"> INTERNAL ORGANS: Heart, Lungs, Liver, Spleen, Pancreas, Kidneys,
                        Bladder, Stomach, Intestines, Reproductive Organs. </div>
                    <button type="button" class="injury-popup-btn js-injury-popup-button btn btn-primary"
                        data-target-id="internal-organs" aria-label="Add injury to list">Add</button>
                </div>
                <div class="injury-popup-wrap js-injury-popup-wrap popup-skin js-skin" data-popup-id="skin">
                    <div class="injury-popup-title"> SKIN: The body's largest organ, covering and protecting all
                        external
                        surfaces. </div>
                    <button type="button" class="injury-popup-btn js-injury-popup-button btn btn-primary"
                        data-target-id="skin" aria-label="Add injury to list">Add</button>
                </div>
                <div class="injury-popup-wrap js-injury-popup-wrap popup-nerv-system js-nerv-system"
                    data-popup-id="nerv-system">
                    <div class="injury-popup-title"> CIRCULATORY AND NERVOUS SYSTEMS: Includes Blood Vessels and Nerves
                        throughout the body. </div>
                    <button type="button" class="injury-popup-btn js-injury-popup-button btn btn-primary"
                        data-target-id="nerv-system" aria-label="Add injury to list">Add</button>
                </div>
            </div>

        </div>
    </div>
    <div class="medical-chronology-request-footer">
        <div class="medical-chronology-request-footer-content">

            <svg class="icon icon-shield ">
                <use href="/assets/themes/default/icon/icons/icons.svg#shield" />
            </svg>

            <p class="medical-chronology-request-footer-content-text">Your privacy is our priority. Rest assured, your
                personal information is securely collected and protected.</p>
        </div>
        <div class="medical-chronology-request-footer-buttons">
            <button type="button" class="medical-chronology-request-footer__reset-btn">Reset Fields</button>
            <button type="button"
                class="btn btn-primary medical-chronology-request-footer__submit-btn js-medical-chronology-request-submit-btn"
                data-href-to="<?=route_to('medical-chronology-review')?>">Review</button>
        </div>
    </div>
</section>



<?= $this->section('extra-js') ?>
<script>
// TODO - delete IT! only for test
$(document).ready(function () {
    // Додати кнопку для заповнення фейковими даними
    $('#medical-chronology-request').append('<button type="button" class="btn btn-secondary mt-3" id="fill-fake-data">Fill the form</button>');

    // Генератор випадкових рядків
    function getRandomString(length) {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let result = '';
        for (let i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        return result;
    }

    // Генератор випадкової дати у форматі YYYY-MM-DD
    function getRandomDate(startYear, endYear) {
        const start = new Date(startYear, 0, 1);
        const end = new Date(endYear, 11, 31);
        const randomDate = new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));
        return randomDate.toISOString().split('T')[0];
    }

    // Генератор випадкового імені
    function getRandomName() {
        const names = ['John', 'Jane', 'Alex', 'Emily', 'Chris', 'Anna', 'Mike', 'Laura'];
        return names[Math.floor(Math.random() * names.length)];
    }

    // Генератор випадкового прізвища
    function getRandomLastName() {
        const lastNames = ['Smith', 'Johnson', 'Brown', 'Taylor', 'Anderson', 'Thomas', 'Jackson', 'White'];
        return lastNames[Math.floor(Math.random() * lastNames.length)];
    }


    // Генератор випадкової локації
    function getRandomLocation() {
        const locations = ['Main Street 123', 'Broadway Ave 456', 'Oak Drive 789', 'Maple Street 101'];
        return locations[Math.floor(Math.random() * locations.length)];
    }

    // Генератор випадкової статі
    function getRandomGender() {
        const genders = ['Male', 'Female'];
        return genders[Math.floor(Math.random() * genders.length)];
    }

    // Генератор випадкового типу вимоги (Claim Type)
    function getRandomClaimType() {
        const claimTypes = ['Bodily Injury', 'Disability Claim', 'Nursing Home Negligence', 'Workers’ Compensation'];
        return claimTypes[Math.floor(Math.random() * claimTypes.length)];
    }

    // Обробник події натискання на кнопку
    $('#fill-fake-data').click(function () {
        // Заповнити текстові та датовані поля випадковими значеннями
        $('#medical_chronology_request_claim_number').val('CLM'+getRandomString(6));
        
        $('#medical_chronology_request_plaintiff_date_of_incident').val(getRandomDate(2015, 2024));
        $('#medical_chronology_request_plaintiff_location_of_accident').val(getRandomLocation());
        $('#medical_chronology_request_plaintiff_first_name').val(getRandomName());
        $('#medical_chronology_request_plaintiff_last_name').val(getRandomLastName()).trigger('input');
        $('#medical_chronology_request_plaintiff_date_of_birth').val(getRandomDate(1950, 2022));
        
        const randomGender = getRandomGender();
        $('#medical_chronology_request_plaintiff_gender').val(randomGender);
        $('#medical_chronology_request_plaintiff_gender').parent().find('.js-medical-chronology-request-dropdown-trigger .value').text(randomGender);  // Оновлення відображення статі

        $('#defendant_first_name').val(getRandomName());
        $('#defendant_last_name').val(getRandomLastName());
        
        const randomClaimType = getRandomClaimType();
        $('#medical_chronology_request_claim_type').val(randomClaimType);
        $('#medical_chronology_request_claim_type').parent().find('.js-medical-chronology-request-dropdown-trigger .value').text(randomClaimType);  // Оновлення відображення типу вимоги

        const event = new Event('input', { bubbles: true });
        document.getElementById('defendant_last_name').dispatchEvent(event);

        $('.js-medical-chronology-request-submit-btn').removeAttr('disabled');

    });

    

});

</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>