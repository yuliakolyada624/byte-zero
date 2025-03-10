<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="Content-Type" content="text/html charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

		<title>Med-Test | Verify email</title>
	</head>
	<body>
		<style>
			.ExternalClass {
				width: 100%;
			}

			.ExternalClass p,
			.ExternalClass span,
			.ExternalClass font,
			.ExternalClass td {
				line-height: inherit;
			}

			* {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
				font-family: "Poppins", sans-serif;
				font-style: normal;
			}

			html,
			body {
				padding: 0;
				margin: 0;
				font-family: "Poppins", sans-serif;
				font-style: normal;
				font-weight: 400;
				font-size: 14px;
				line-height: 20px;
				color: #131316;
				background: #ffffff;
			}

			body {
				padding: 0 15px;
			}

			table {
				border-spacing: 0;
				margin: 77px auto 0;
				padding: 0 40px 36px;

				border: 1px solid #D6DADE;
				border-radius: 16px;

				max-width: 634px;
				width: 100%;
				text-align: center;
			}

			thead tr td {
				padding: 22px 0;
				border-bottom: 1px solid #D6DADE;
			}

			tbody tr td h1 {
				font-size: 24px;
				line-height: 40px;
				font-weight: 500;
				padding: 32px 0 0;
			}
			tbody tr td p {
				max-width: 427px;
				margin: 0 auto;
				text-align: center;
				padding: 10px 0 0;
			}
			tbody tr td p span {
				color: #5DA0EF
			}

			tbody tr td a.reset {
				border: none;
				margin: 50px auto 0;
				font-weight: 500;
				max-width: 394px;
				width: 100%;
				display: block;
				width: 100%;
				font-size: 14px;
				line-height: 22px;
				font-weight: 500;
				text-decoration: none;
				color: #FFFFFF;
				background-color: #5DA0EF;
				text-align: center;
				padding: 10px 0;
				border-radius: 8px;
			}

			tr td > a {
				display: block;
				color: #5DA0EF;
				text-decoration: none;
				margin: 16px 0 0;
			}

			tr td.bottom {
				padding: 50px 0 0;
				margin: 0 0 20px;
			}

			tr td .low-border-padding {
				padding: 0 34px;
			}

			tr td p.bottom-text {
				max-width: 486px;
				padding: 0 0 20px;
				border-bottom: 1px solid #D6DADE;
			}
			tr td p.bottom-text a {
				color: #5DA0EF;
				text-decoration: none;
			}
			tr td p.table-footer-text {
				padding: 20px 0 0;
			}
			p.footer {
				font-size: 12px;
				line-height: 22px;
				font-weight: 400;
				text-align: center;
				margin: 77px 0 0;
			}
		</style>
		<table>
			<thead>
				<tr>
					<td><img src="<?= base_url() ?>assets/themes/default/img/content/auth-logo.png" alt="Logo" width="198" height="36"></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<h1>Verify Account Email</h1>
					</td>
				</tr>
				<tr>
					<td>
            <?php 
              /** @var Session $authenticator */
                $authenticator = auth('session')->getAuthenticator();

                $user = $authenticator->getPendingUser();
                if ($user) {
            ?>
              <p>The email <a href="mailto:<?=$user->email?>"><?=$user->email?></a> 
              was entered for this account. Please verify this email address by clicking the button below. This link will expire in 48 hours.</p>
            <?php } ?>
					</td>
				</tr>
				<tr>
					<td>
						<a class="reset" href="<?=base_url()?>accounts/approve/<?= $code ?>/<?=$user->id?>">Verify this email</a>
					</td>
				</tr>
				<tr>
					<td>
						<a href="<?=base_url()?>accounts/approve/<?= $code ?>/<?=$user->id?>"><?=base_url()?>accounts/approve/<?= $code ?>/<?=$user->id?></a>
					</td>
				</tr>
				<tr>
					<td class="bottom">
						<div class="low-border-padding">
							<p class="bottom-text">
								If the button above is disabled, try to copy and paste the link displayed into your browser. If you persist to have problems, contact our support team at
								<a href="mailto:support@med-test.ai">support@med-test.ai</a>
							</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<p class="table-footer-text">If this request was a mistake, Please ignore this email to avoid unwated account changes.</p>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="footer">© 2023-<?=date("Y")?> Med-Test. All rights reserved.</p>
	</body>
</html>


<!-- 
Debug INFO: 
<b><?= lang('Auth.emailInfo') ?></b>
    <p><?= lang('Auth.emailIpAddress') ?> <?= esc($ipAddress) ?></p>
    <p><?= lang('Auth.emailDevice') ?> <?= esc($userAgent) ?></p>
    <p><?= lang('Auth.emailDate') ?> <?= esc($date) ?></p>
</body>

</html> -->

