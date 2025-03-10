<?php
// dd($transactions);
if (!empty($transactions)): ?>
    <div class="table-responsive transactions">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Order ID/<br> Transaction ID</th>
                    <th scope="col">
                        Case Name
                        <button type="button" class="table-btn">

                            <svg class="icon icon-arrows-sort ">
                                <use href="/assets/themes/default/assets/icon/icons/icons.svg#arrows-sort" />
                            </svg>

                        </button>
                    </th>
                    <th scope="col">
                        Case Type
                    </th>
                    <th scope="col">Product</th>
                    <th scope="col">
                        Date/<br>Time
                        <button type="button" class="table-btn">

                            <svg class="icon icon-arrows-sort ">
                                <use href="/assets/themes/default/assets/icon/icons/icons.svg#arrows-sort" />
                            </svg>

                        </button>
                    </th>
                    <th scope="col">
                        Amount
                        <button type="button" class="table-btn">

                            <svg class="icon icon-arrows-sort ">
                                <use href="/assets/themes/default/assets/icon/icons/icons.svg#arrows-sort" />
                            </svg>

                        </button>
                    </th>
                    <th scope="col">Payment Method</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <td>
                            <span class="order-id"><?= $transaction['order_number'] ?></span>
                            <?php if($transaction['is_refund']==1): ?>
                                <span class="status">Refund</span>
                            <?php endif; ?>
                            <br>
                            <?= $transaction['transaction_number'] ?>
                        </td>
                        <td>
                            <?= $transaction['case_name'] ?>
                        </td>
                        <td>
                            <?= $transaction['claim_type_text'] ?>
                        </td>
                        <td>
                            <?= $transaction['report_type_text'] ?>
                        </td>
                        <td>
                            <?= date('m-d-Y', strtotime($transaction['created_at'])) ?><br>
                            <?= date('g:i A', strtotime($transaction['created_at'])) ?> EST
                        </td>
                        <td>
                            $<?= number_format($transaction['authorization_amount'] / 100, 2) ?>
                        </td>
                        <td>
                            <img src="/assets/themes/default/img/content/payment-systems/<?= str_replace(' ', '-', strtolower($transaction['card_type'])) ?>.png"
                                alt="<?= $transaction['card_type'] ?>" width="30" height="18">
                            Ends in: <?= $transaction['card_ends_in'] ?>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <svg class="icon icon-dots-vertical">
                                        <use href="/assets/themes/default/icon/icons/icons.svg#dots-vertical" />
                                    </svg>
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item">
                                        <a href="<?= base_url() ?>/transactions/invoice/<?= $transaction['id'] ?>"
                                            target="_blank">
                                            <svg class="icon icon-download">
                                                <use href="/assets/themes/default/icon/icons/icons.svg#download" />
                                            </svg>
                                            Invoice
                                        </a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a href="<?= base_url() ?>/transactions/receipt/<?= $transaction['id'] ?>"
                                            target="_blank">
                                            <svg class="icon icon-download">
                                                <use href="/assets/themes/default/icon/icons/icons.svg#download" />
                                            </svg>
                                            Receipt
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <nav aria-label="pagination" class="pagination-wrapper pagination-transactions">

    <?= $pagination ?>
   
    </nav>
<?php else: ?>
    <div class="empty-table mt-5">
        <svg class="icon icon-info-circle ">
            <use href="/assets/themes/default/icon/icons/icons.svg#info-circle"></use>
        </svg>
        <h3>
            There are no transactions at the moment.
        </h3>
    </div>
<?php endif; ?>