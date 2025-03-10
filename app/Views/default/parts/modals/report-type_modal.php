<!-- Modal -->
<div class="modal fade report" id="report-type" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="staticBackdropLabel">Select Report Type</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="<?= url_to('medical-chronology-request') ?>">
                <?= csrf_field() ?>
            
                <div class="modal-body">
                    Please specify the product you wish to order.
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="reportType" value="medical_chronology" id="medicalChronology"
                            required>
                        <label class="form-check-label" for="medicalChronology">
                            <span class="form-check-label__title">Medical Chronology</span>
                            <span>
                                A detailed timeline that outlines all medical events and treatments a plaintiff has
                                received.
                                It organizes information from medical records in chronological order, making it easier
                                to understand
                                a patient's medical history, treatment progression, and any significant health events.
                            </span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="reportType" value="billing_summary" id="billingSummary"
                            required>
                        <label class="form-check-label" for="billingSummary">
                            <span class="form-check-label__title">Billing Summary</span>
                            <span>
                                A document that lists all the charges for medical services and treatments a plaintiff
                                has received.
                                It includes details such as the dates of service, types of services provided, the amount
                                charged,
                                payments made, and the balance due.
                            </span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="reportType" value="medical_chronology_and_billing_summary" id="all" required>
                        <label class="form-check-label" for="all">
                            <span class="form-check-label__title">
                                Medical Chronology + Billing Summary
                                <span class="badge status light-green">
                                    SAVE 15%
                                </span> </span>
                        </label>
                    </div>

                </div>
                <div class="modal-footer d-flex align-items-center justify-content-between mt-2">

                    <button class="btn btn-primary " type="submit" aria-label="Continue">

                        Continue
                    </button>

                    <a class="btn-link" href="#">
                        <span>View Service Fees</span>

                        <svg class="icon icon-share ">
                            <use href="/assets/themes/default/icon/icons/icons.svg#share" />
                        </svg>

                    </a>
                </div>
            </form>
        </div>
    </div>
</div>