<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - Med-Test.AI </title>    
    <meta property="og:image" content="<?= base_url() ?>assets/themes/default/favicons/favicon.png" />
	<meta property="og:image:secure_url" content="<?= base_url() ?>assets/themes/default/favicons/favicon.png" />
	<link rel="shortcut icon" type="image/png" href="<?= base_url() ?>assets/themes/default/favicons/favicon.png" />

	<meta property="og:image:width" content="32" />
	<meta property="og:image:height" content="32" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:site" content="@example_com" />

	<!-- Fix IOS zoom to input on focus -->
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no , maximum-scale=1.0, user-scalable=no" /> -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no , maximum-scale=1.0, user-scalable=no" />
	<meta content="true" name="HandheldFriendly" />
	<meta content="width" name="MobileOptimized" />
	<meta content="yes" name="apple-mobile-web-app-capable" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/themes/default/css/app.min.css" />
    <style>
        body {
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .invoice-header {
            text-align: center;
        }
        .invoice-header h1 {
            margin: 0;
        }
        .invoice-summary {
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .amount-due {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="invoice-header">
        <picture class="header__image">
              <source srcset="/assets/themes/default/img/./content/logo.webp" type="image/webp" class="header__img " />
              <img src="/assets/themes/default/img/./content/logo.png" alt="img" class="header__img " width="146" height="28" />
        </picture>
        <p><?= date('D, M d, Y') ?></p> 

        <h2>Invoice</h2>
        <p>Invoice Number: <?= esc($transaction['id']) ?></p>
        <p>Invoiced On: <?= esc(date('M d, Y', strtotime($transaction['time_paid']))) ?></p>
    </div>
<?php
helper('App\Modules\User\Helpers\users');

//d($transaction);
?>
    <div class="invoice-summary">
        <h5>Order Summary</h5>
        <div class="row justify-content-between mt-3 mb-5">
            <div class="col-4">
                <p><strong>Order ID:</strong> <?= esc($transaction['order_id']) ?></p>
                <p><strong>Ordered By:</strong> <?= esc(get_user_full_name($transaction['creater_user_id'])) ?></p>
                <p><strong>Client:</strong> <?= esc($transaction['plaintiff_first_name']) ?> <?= esc($transaction['plaintiff_last_name']) ?></p>
            </div>
            <div class="col-4 text-end">
                <p><strong>Claim Number:</strong> <?= esc($transaction['claim_number']) ?></p>
                <p><strong>Plaintiff Full Name:</strong> <?= esc($transaction['plaintiff_first_name']) ?> <?= esc($transaction['plaintiff_last_name']) ?></p>
                <p><strong>Case Name:</strong> <?= esc($transaction['case_name']) ?></p>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Report Type</th>
                <th>Claim Type</th>
                <th>Exhibits</th>
                <th>Page Count</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= esc($transaction['report_type_text']) ?></td>
                <td><?= esc($transaction['claim_type_text']) ?></td>
                <td><?= esc($transaction['exhibit_count']) ?></td>
                <td><?= esc($transaction['page_count']) ?></td>
                <td><?= esc('$' . number_format($transaction['authorization_amount'], 2)) ?></td>
            </tr>
        </tbody>
    </table>
    <div class="row justify-content-end  mt-3">
        <div class="amount-summary col-3 justify-content-end">
            <p class="amount-due">Amount Due: <?= esc('$' . number_format($transaction['authorization_amount'], 2)) ?></p>
            <p class="amount-due">Amount Paid: <?= esc('$' . number_format($transaction['authorization_amount'], 2)) ?></p>
            <p class="amount-due">Balance: <?= esc('$' . number_format($transaction['authorization_amount'], 2)) ?></p>
            <p class="small">All amounts are in USD</p>
        </div>
    </div>

    <div class="row justify-content-between mt-3">
        <div class="payable-to col-3">
            <h5>Payable To</h5>
            <p>Med-Test.AI LLC. - EIN: 1892282192</p>
            <p>300 SE 2nd Street, Suite 600</p>
            <p>Fort Lauderdale, FL 33301, USA</p>
        </div>

        <div class="invoice-to col-3 text-end">
            <h5>Invoice To</h5>
            <p>The Salameh Law Group, P.A.</p>
            <p>2133 Winkler Avenue</p>
            <p>Fort Myers, FL 33901, USA</p>
        </div>
    </div>

    <div class="contact-info mt-5">
        <p>For billing support call 1-415-406-9002 or email <a href="mailto:billing@med-test.ai">billing@med-test.ai</a></p>
    </div>

    <p class="text-center">1 of 1</p>
</div>

<!-- JAVASCRIPT -->
<script src="<?=base_url()?>assets/themes/default/js/vendor.js"></script>
<script src="<?=base_url()?>assets/themes/default/js/main.js"></script>

</body>
</html>
