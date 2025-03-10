<div class="transactions-filters__body">
    <div class="row transactions-filters__wrap">

        <div class="col col-4">
            <div class="component__dropdown2 transactions-filter__select-component " data-search="false">
                <label for="transactionsFilterTransactionType" class="form-label">Transaction Type</label>
                <select id="transactionsFilterTransactionType" class="form-select js__select2 w-100" name="transaction_type" placeholder="Select" data-placeholder="Select">
                    <option value="">Select</option>
                    <option value="clear">Clear Selection</option>
                    <option value="purchase">Purchase</option>
                    <option value="refund">Refund</option>
                </select>
                <div class="invalid-feedback js-field-error"></div>
            </div>
        </div>

        <div class="col col-4">
            <div class="component__dropdown2 transactions-filter__select-component " data-search="false">
                <label for="transactionsFilterCaseType" class="form-label">Case Type</label>
                <select id="transactionsFilterCaseType" class="form-select js__select2 w-100" name="case_type" placeholder="Select" data-placeholder="Select">
                    <option value="">Select</option>
                    <?php
                    $claimTypes = [
                        'body_injury' => 'Body Injury',
                        'disability_claim' => 'Disability Claim',
                        'nursing_home_negligence' => 'Nursing Home Negligence',
                        'workers_compensation' => 'Workers Compensation',
                    ];
                    ?>
                    <?php foreach ($claimTypes as $key => $value): ?>
                        <option value="<?= $key ?>"><?= $value ?></option>
                    <?php endforeach; ?>
                    >
                </select>
                <div class="invalid-feedback js-field-error"></div>
            </div>
        </div>

        <div class="col col-4">
            <div class="component__dropdown2 transactions-filter__select-component " data-search="false">
                <label for="transactionsFilterProduct" class="form-label">Product</label>
                <select id="transactionsFilterProduct" class="form-select js__select2 w-100" name="product" placeholder="Select" data-placeholder="Select">
                    <option value="">Select</option>
                    <?php
                    $types = [
                        'medical_chronology' => 'Medical Chronology',
                        'billing_summary' => 'Billing Summary',
                        'medical_chronology_and_billing_summary' => 'Medical Chronology and Billing Summary',
                    ];
                    ?>
                    <?php foreach ($types as $key => $value): ?>
                        <option value="<?= $key ?>"><?= $value ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback js-field-error"></div>
            </div>
        </div>

        <div class="col col-4">
            <div class="component__dropdown2 transactions-filter__select-component " data-search="true">
                <label for="transactionsFilterOrderedBy" class="form-label">Ordered By</label>
                <select id="transactionsFilterOrderedBy" class="form-select js__select2 w-100" name="ordered_by" placeholder="Select" data-placeholder="Select">
                    <option value="">Select</option>
                    <?php foreach ($filter_data['ordered_by_list'] as $creator): ?>
                        <option value="<?= $creator->id ?>"><?= $creator->first_name ?> <?= $creator->last_name ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback js-field-error"></div>
            </div>
        </div>

        <div class="col col-4">
            <div class="component__dropdown2 transactions-filter__select-component " data-search="false">
                <label for="transactionsFilterPaymentMethod" class="form-label">Payment Method</label>
                <select id="transactionsFilterPaymentMethod" class="form-select js__select2 w-100" name="payment_method" placeholder="Select" data-placeholder="Select">
                    <option value="">Select</option>
                    <option value="clear">Clear Selection</option>
                    <option value="visa">Visa</option>
                    <option value="mastercard">Mastercard</option>
                    <option value="american_express">American Express</option>
                </select>
                <div class="invalid-feedback js-field-error"></div>
            </div>
        </div>

    </div>
</div>