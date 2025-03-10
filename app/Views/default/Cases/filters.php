<div class="cases-filters__body">
    <div class="row cases-filters__wrap">

        <div class="col col-6">
            <div class="component__dropdown2 cases-filter__select-component cases-filter__filter-status <?= (isset($filter_data['progress_status']) && !empty($filter_data['progress_status'])) ? 'has-value' : '' ?>" data-search="false">
                <label for="casesFilterStatus" class="form-label">Progress Status</label>
                <select id="casesFilterStatus" class="form-select js__select2 w-100" name="progress_status" placeholder="Select" data-placeholder="Select">
                    <option value="">Select</option>
                    <option value="clear">Clear Selection</option>
                    <option data-color="#088C5E" value="ready" <?= (isset($filter_data['progress_status']) && $filter_data['progress_status'] == 'ready') ? 'selected' : '' ?>>Ready - Attorney Approved</option>
                    <option data-color="#FF7400" value="reviewed" <?= (isset($filter_data['progress_status']) && $filter_data['progress_status'] == 'reviewed') ? 'selected' : '' ?>>Reviewer Analyzed</option>
                    <option data-color="#FFCE00" value="processed" <?= (isset($filter_data['progress_status']) && $filter_data['progress_status'] == 'processed') ? 'selected' : '' ?>>AI Processed</option>
                    <option data-color="#BBC4D9" value="received" <?= (isset($filter_data['progress_status']) && $filter_data['progress_status'] == 'received') ? 'selected' : '' ?>>Order Received</option>
                </select>
                <div class="invalid-feedback js-field-error"></div>
            </div>
        </div>

        <div class="col col-6">
            <div class="component__dropdown2 cases-filter__select-component <?= (isset($filter_data['ordered_by']) && !empty($filter_data['ordered_by'])) ? 'has-value' : '' ?>" data-search="true">
                <label for="casesFilterOrderedBy" class="form-label">Ordered By</label>
                <select id="casesFilterOrderedBy" class="form-select js__select2 w-100" name="ordered_by" placeholder="Select" data-placeholder="Select">
                    <option value="">Select</option>
                    <option value="clear">Clear Selection</option>
                    <?php foreach ($filter_data['ordered_by_list'] as $creator): ?>
                        <option value="<?= $creator->id ?>" <?= (isset($filter_data['ordered_by']) && $creator->id == $filter_data['ordered_by']) ? 'selected' : '' ?>>
                            <?= $creator->first_name ?> <?= $creator->last_name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback js-field-error"></div>
            </div>
        </div>

        <div class="col col-6">
            <div class="component__dropdown2 cases-filter__select-component <?= (isset($filter_data['report_type']) && !empty($filter_data['report_type'])) ? 'has-value' : '' ?>" data-search="false">
                <label for="casesFilterReportType" class="form-label">Report Type</label>
                <select id="casesFilterReportType" class="form-select js__select2 w-100" name="report_type" placeholder="Select" data-placeholder="Select">
                    <option value="">Select</option>
                    <option value="clear">Clear Selection</option>
                    <?php
                    $report_type_list = [
                        'medical_chronology' => 'Medical Chronology',
                        'billing_summary' => 'Billing Summary',
                        'both' => 'Medical Chronology + Billing Summary',
                    ];
                    foreach ($report_type_list as $key => $value):
                    ?>
                        <option value="<?= $key ?>" <?= (isset($filter_data['report_type']) && $key == $filter_data['report_type']) ? 'selected' : '' ?>><?= $value ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback js-field-error"></div>
            </div>
        </div>

        <div class="col col-6">
            <div class="component__dropdown2 cases-filter__select-component <?= (isset($filter_data['assignee']) && !empty($filter_data['assignee'])) ? 'has-value' : '' ?>" data-search="true">
                <label for="casesFilterAssignee" class="form-label">Assignee</label>
                <select id="casesFilterAssignee" class="form-select js__select2 w-100" name="assignee" placeholder="Select" data-placeholder="Select">
                    <option value="">Select</option>
                    <option value="clear">Clear Selection</option>
                    <?php foreach ($filter_data['assignee_list'] as $assignee): ?>
                        <option 
                            value="<?= $assignee->id ?>" 
                            <?= (isset($filter_data['assignee']) && $assignee->id == $filter_data['assignee']) ? 'selected' : '' ?>
                        >
                            <?= $assignee->first_name ?> <?= $assignee->last_name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback js-field-error"></div>
            </div>
        </div>

    </div>
</div>