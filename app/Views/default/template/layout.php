<!DOCTYPE html>
<?php
$lang = get_language();
?>
<html lang="<?= $lang ?>">

<head>
	<meta name="robots" content="noindex,nofollow" />

	<meta charset="UTF-8">


	<meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>">
	<meta name="CI_ENV" content="<?= getenv('CI_ENVIRONMENT') ?>">
	
	<title><?= $title ?? 'Welcome to Mebibrief!' ?></title>

	<!-- Open Graph meta -->
	<meta property="og:site_name" content="Mebibrief">
	<meta property="og:title" content="Mebibrief" />
	<meta property="og:description" content="Mebibrief" />
	<meta property="og:locale" content="en">
	<meta property="og:type" content="website" />
	<meta property="og:url" content="<?= base_url() ?>" />
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
	<meta name="keywords" content="Mebibrief" />
	<meta name="description" content="Mebibrief" />
	<meta name="theme-color" content="#ffffff">

	<!-- [if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE = edge" />
	<![endif] -->

	<link rel="stylesheet" href="<?= base_url() ?>assets/themes/default/css/app.min.css" />


	<!-- [if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
	<![endif]            -->
	
	<link rel="canonical" href="<?= current_url() ?>" />
	<?php
	$hrefLanguages = getHrefLanguages();
	foreach ($hrefLanguages as $code => $lang_code) :
	?>
		<link href="<?= $lang_code ?>" hreflang="<?= $code ?>" rel="alternate" />
	<?php
	endforeach;
	?>


	<?= $this->renderSection('extra-css') ?>

	<!-- STYLES -->
	<style>
		
		.user-avatar, .user__img, .photo__img {
			border-radius: 50%;
			border: 1px solid #D4DCE4;
		}
	</style>

	<script>
		var SITEURL = "<?= base_url() ?>";
		languageData = '{"user_error_name_blankspace":"No blank space allowed.","card_error_card_number_required":"Please enter card number.","card_error_card_number_numeric":"Please enter only numerical values.","card_error_month_required":"Please select month.","card_error_year_required":"Please select year.","card_error_first_name_required":"Please enter first name.","card_error_last_name_required":"Please enter last name.","card_error_cvv_number_required":"Please enter cvv number.","card_error_cvv_number_numeric":"Please enter only numerical values."}';
		var languageData = JSON.parse(languageData);
	</script>
</head>

<body class="<?= $bodyClass ?? 'index-page' ?>">
	<div class="container-fluid">
		<div class="row gap-3">
        
		<?= $this->include('template/partials/sidenav') ?>

		<main class="col pe-4">
			<?= $this->include('template/partials/header') ?>
			<!-- CONTENT view -->
			<?php
			try {
				echo view($view);
			} catch (Exception $e) {
				//echo "<pre><code>$e</code></pre>";

			}
			?>
			<!-- CONTENT Section -->
			<?=$this->renderSection('content') ?>

			<!-- Footer -->
			<?= $this->include('template/partials/footer') ?>

		</main>
    </div>
		<?= $this->renderSection('offcanvas') ?>
		
		<!-- REQUIRED SCRIPTS -->
		<?= $this->include('template/partials/vendor-scripts') ?>


		<?= $this->renderSection('extra-js') ?>
		<!-- SCRIPTS -->
		<script>
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
				}
			});
		</script>
</body>
</html>
