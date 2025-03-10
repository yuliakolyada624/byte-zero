<?php
// dd($orders);
// 
helper('App\Modules\User\Helpers\users');

if (!empty($orders)): ?>
    <?php foreach ($orders as $order): ?>
        <div class="offcanvas cases offcanvas-end" tabindex="-1" id="order-details-<?= $order['id'] ?>"
            aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h3 class="offcanvas-title" id="offcanvasRightLabel">Cases</h3>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h1 class="mb-0">Order Number: <?= $order['order_number'] ?></h1>
                    <span class="badge status <?= $order['badge_status']?>">
                        <?= $order['status'] ?>
                    </span>
                </div>
                <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
                    <button class="btn btn-primary sidebar-btn" type="button" aria-label="Order Details" 
                            data-bs-toggle="offcanvas" data-bs-target="#order-full-details-<?= $order['id'] ?>" aria-controls="orderDetails">
                        <svg class="icon icon-order-details ">
                            <use href="/assets/themes/default/icon/icons/icons.svg#order-details" />
                        </svg>
                        Order Details
                    </button>


                    <button class="btn btn-primary sidebar-btn" type="button" aria-label="View Reports"
                        data-bs-toggle="offcanvas" data-bs-target="#order-report-<?= $order['id'] ?>" aria-controls="viewReports">

                        <svg class="icon icon-reports ">
                            <use href="/assets/themes/default/icon/icons/icons.svg#reports" />
                        </svg>

                        View Reports
                    </button>

                </div>
                <div class="order-progress mb-4">
                    <h3 class="mb-3">Order Progress</h3>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="checkbox">
                            <svg class="icon icon-checkbox <?= !empty($order['time_created']) ? 'checked' : 'empty' ?>">
                                <use href="/assets/themes/default/icon/icons/icons.svg#<?= !empty($order['time_created']) ? 'checkbox' : 'checkbox-empty' ?>" />
                            </svg>
                        </div>
                        <div class="w-50">Order Received</div>
                        <div class="w-50 text-end fw-semibold"><?= !empty($order['time_created']) ? date("d-m-Y H:i", strtotime($order['time_created'])) . ' EST' : '' ?></div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="checkbox">
                            <svg class="icon icon-checkbox <?= !empty($order['time_ml_processed']) ? 'checked' : 'empty' ?>">
                                <use href="/assets/themes/default/icon/icons/icons.svg#<?= !empty($order['time_ml_processed']) ? 'checkbox' : 'checkbox-empty' ?>" />
                            </svg>
                        </div>
                        <div class="w-50">AI Processed</div>
                        <div class="w-50 text-end fw-semibold"><?= !empty($order['time_ml_processed']) ? date("d-m-Y H:i", strtotime($order['time_ml_processed'])) . ' EST' : '' ?></div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="checkbox">
                            <svg class="icon icon-checkbox <?= !empty($order['time_fully_reviewed']) ? 'checked' : 'empty' ?>">
                                <use href="/assets/themes/default/icon/icons/icons.svg#<?= !empty($order['time_fully_reviewed']) ? 'checkbox' : 'checkbox-empty' ?>" />
                            </svg>
                        </div>
                        <div class="w-50">Reviewer Analyzed</div>
                        <div class="w-50 text-end fw-semibold"><?= !empty($order['time_fully_reviewed']) ? date("d-m-Y H:i", strtotime($order['time_fully_reviewed'])) . ' EST' : '' ?></div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="checkbox">
                            <svg class="icon icon-checkbox <?= !empty($order['time_approval']) ? 'checked' : 'empty' ?>">
                                <use href="/assets/themes/default/icon/icons/icons.svg#<?= !empty($order['time_approval']) ? 'checkbox' : 'checkbox-empty' ?>" />
                            </svg>
                        </div>
                        <div class="w-50">Attorney Approved</div>
                        <div class="w-50 text-end fw-semibold"><?= !empty($order['time_approval']) ? date("d-m-Y H:i", strtotime($order['time_approval'])) . ' EST' : '' ?></div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="checkbox">
                            <svg class="icon icon-checkbox <?= !empty($order['time_approval']) ? 'checked' : 'empty' ?>">
                                <use href="/assets/themes/default/icon/icons/icons.svg#<?= !empty($order['time_approval']) ? 'checkbox' : 'checkbox-empty' ?>" />
                            </svg>
                        </div>
                        <div class="w-50">Order Ready and Shared:</div>
                        <div class="w-50 text-end fw-semibold"><?= !empty($order['time_approval']) ? date("d-m-Y H:i", strtotime($order['time_approval'])) . ' EST' : '' ?></div>
                    </div>
                </div>
                <div class="mb-4">
                    <h3 class="mb-3">Assignees</h3>
                    <div class="card p-4 rounded-3">
                        <button class="btn-link">

                            <svg class="icon icon-plus ">
                                <use href="/assets/themes/default/icon/icons/icons.svg#plus" />
                            </svg>

                            Add Report Assignees
                        </button>
                    </div>
                </div>
                
        </div>
        <?php ?>
    <?php endforeach; ?>
<?php endif; ?>
