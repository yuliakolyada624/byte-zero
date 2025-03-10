<?php
// dd($transactions);
// 
if (!empty($transactions)): ?>
    <?php foreach ($transactions as $transaction): ?>
        <div class="offcanvas cases offcanvas-end" tabindex="-1" id="transaction-details-<?= $transaction['id'] ?>"
            aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h3 class="offcanvas-title" id="offcanvasRightLabel">Transactions</h3>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h1 class="mb-0">Refund Request</h1>
                    
                </div>
                <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
                    

                </div>
                
                <div>
                    <h3 class="mb-3">Payment Information</h3>
                    <div class="card p-4 bg-main-light border-0">
                        <table class="mb-4">
                            <tbody>
                                <tr>
                                    <td class="pb-2">Transaction ID:</td>
                                    <th class="text-end pb-2 fw-semibold" scope="row">---ABD234BDI23234</th>
                                </tr>
                                <tr>
                                    <td class="pb-2">Payment Method:</td>
                                    <th class="text-end pb-2 fw-semibold" scope="row">--- Visa ending in 3241</th>
                                </tr>
                                <tr>
                                    <td class="pb-2">Payment Date:</td>
                                    <th class="text-end pb-2 fw-semibold" scope="row">--- 05-11-2024 <span
                                            class="separator">|</span> 4:35 PM
                                        EST</th>
                                </tr>
                                <tr>
                                    <td class="pb-2">Currency:</td>
                                    <th class="text-end pb-2 fw-semibold" scope="row">USD</th>
                                </tr>
                                <tr>
                                    <td>Billed Amount:</td>
                                    <th class="text-end fw-semibold" scope="row">--$250</th>
                                </tr>
                            </tbody>
                        </table>
                      
                    </div>
                </div>
            </div>
        </div>
        
    <?php endforeach; ?>
<?php endif; ?>