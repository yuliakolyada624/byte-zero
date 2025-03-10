<?php 
    // dd($orders);
    if (!empty($orders)): ?>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Order No./<br> Claim No.</th>
                    <th scope="col">
                        Order Date
                        <button type="button" class="table-btn">

                        <svg class="icon icon-arrows-sort ">
                            <use href="/assets/themes/default/icon/icons/icons.svg#arrows-sort" />
                        </svg>

                        </button>
                    </th>
                    <th scope="col">
                        Case Name
                        <button type="button" class="table-btn">

                        <svg class="icon icon-arrows-sort ">
                            <use href="/assets/themes/default/icon/icons/icons.svg#arrows-sort" />
                        </svg>

                        </button>
                    </th>
                    <th scope="col">Report Type</th>
                    <th scope="col">Submitted</th>
                    <th scope="col" colspan="2">
                        Progress Tracker
                        <button type="button" class="table-btn">

                        <svg class="icon icon-arrows-sort ">
                            <use href="/assets/themes/default/icon/icons/icons.svg#arrows-sort" />
                        </svg>

                        </button>
                    </th>
                    <th scope="col" class="text-center">Details</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td class="bordered">
                        <span><?= $order['order_number'] ?><br><?= $order['claim_number'] ?><?= !empty($order['new']) ? '<span class="new-item">New</span>' :  '' ?></span>
                    </td>
                    <td><?= date('m-d-Y', strtotime($order['time_created'])) ?><br><?= date('g:i A', strtotime($order['time_created'])) ?> EST</td>
                    <td><?= $order['case_name'] ?><br> vs. <?= $order['defendant_first_name'] ?> <?= $order['defendant_last_name'] ?></td>
                    <td><?= ucwords(str_replace('_', ' ', $order['report_type'])) ?></td>
                    <td><?= $order['exhibit_count'] ?> Exhibits<br><?= $order['page_count'] ?> Pages</td>
                    
                    <td>
                        <div class="tooltip-trigger">
                            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0"
                                aria-valuemin="0" style="height: 7px" aria-valuemax="100">
                                <div class="progress-bar bg-<?=$order['status_color']?> " style="width: <?= $order['progress'] ?>%"></div>
                            </div>
                            <div class="tooltip-popup center">
                                <div class="tooltip-popup__header">
                                    Progress Tracker
                                    <span class="badge status <?= $order['badge_status']?>"><?=$order['status']?></span>
                                </div>
                                <div class="tooltip-popup__body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="checkbox">
                                            <svg class="icon icon-checkbox <?= !empty($order['time_created']) ? 'checked' : 'empty' ?>">
                                                <use href="/assets/themes/default/icon/icons/icons.svg#<?= !empty($order['time_created']) ? 'checkbox' : 'checkbox-empty' ?>" />
                                            </svg>
                                        </div>
                                        <div class="w-50">Order Received</div>
                                        <div class="w-50 text-end"><?= !empty($order['time_created']) ? date("d-m-Y H:i", strtotime($order['time_created'])) . ' EST' : '' ?></div>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="checkbox">
                                            <svg class="icon icon-checkbox <?= !empty($order['time_ml_processed']) ? 'checked' : 'empty' ?>">
                                                <use href="/assets/themes/default/icon/icons/icons.svg#<?= !empty($order['time_ml_processed']) ? 'checkbox' : 'checkbox-empty' ?>" />
                                            </svg>
                                        </div>
                                        <div class="w-50">AI Processed</div>
                                        <div class="w-50 text-end"><?= !empty($order['time_ml_processed']) ? date("d-m-Y H:i", strtotime($order['time_ml_processed'])) . ' EST' : '' ?></div>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="checkbox">
                                            <svg class="icon icon-checkbox <?= !empty($order['time_fully_reviewed']) ? 'checked' : 'empty' ?>">
                                                <use href="/assets/themes/default/icon/icons/icons.svg#<?= !empty($order['time_fully_reviewed']) ? 'checkbox' : 'checkbox-empty' ?>" />
                                            </svg>
                                        </div>
                                        <div class="w-50">Reviewer Analyzed</div>
                                        <div class="w-50 text-end"><?= !empty($order['time_fully_reviewed']) ? date("d-m-Y H:i", strtotime($order['time_fully_reviewed'])) . ' EST' : '' ?></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="checkbox">
                                            <svg class="icon icon-checkbox <?= !empty($order['time_approval']) ? 'checked' : 'empty' ?>">
                                                <use href="/assets/themes/default/icon/icons/icons.svg#<?= !empty($order['time_approval']) ? 'checkbox' : 'checkbox-empty' ?>" />
                                            </svg>
                                        </div>
                                        <div class="w-50">Attorney Approved</div>
                                        <div class="w-50 text-end"><?= !empty($order['time_approval']) ? date("d-m-Y H:i", strtotime($order['time_approval'])) . ' EST' : '' ?></div>
                                    </div>
                                </div>
                            </div>

                            </div>
                    </td>
                    <td><p><?= $order['progress'] ?>%</p></td>
                    <td class="text-center">
                        <button class="details" type="button" data-bs-toggle="offcanvas" data-bs-target="#order-details-<?= $order['id'] ?>" aria-controls="offcanvasRight">
                            <svg class="icon icon-input-details">
                                <use href="/assets/themes/default/icon/icons/icons.svg#input-details"></use>
                            </svg>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?php if (!empty($pager)): ?>
    <nav aria-label="pagination" class="pagination-wrapper" data-name="<?=$tabName?>">
        <?= $pager->links($tabName) ?>
        <div class="pagination-info">
            <?php
            $total = $pager->getTotal($tabName);
            $perPage = $pager->getPerPage($tabName);
            $currentPage = $pager->getCurrentPage($tabName);
            $start = ($currentPage - 1) * $perPage + 1;
            $end = min($total, $currentPage * $perPage);
            ?>
            Showing <span class="active-items"><?= $start ?> - <?= $end ?></span> 
            of <span class="pagination-total"><?= $total ?></span>
        </div>
    </nav>
    <?php endif; ?>
<?php else: ?>
    <div class="empty-table ">
        <svg class="icon icon-info-circle ">
            <use href="/assets/themes/default/icon/icons/icons.svg#info-circle"></use>
        </svg>
        <h3> There are no report orders at the moment.</h3>
    </div>
<?php endif; ?>