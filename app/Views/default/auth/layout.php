<!DOCTYPE html>
<html lang="en">
<head prefix="">
  <meta charset="UTF-8" />
	<title><?= $title ?? 'Med-Test | Login' ?></title>
  <!-- TODO: Robots no index -->
  <meta name="robots" content="noindex,nofollow" />
  <!-- TODO: Allow http req with no network -->

  <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>">

  <meta name="CI_ENV" content="<?= getenv('CI_ENVIRONMENT') ?>">

  <!-- Open Graph meta -->
  <meta property="og:site_name" content="<?= $title ?? 'Med-Test | Login' ?>">
  <meta property="og:title" content="" />
  <meta property="og:description" content="" />
  <meta property="og:locale" content="en">
  <meta property="og:locale:alternate" content="uk" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="" />
  <meta property="og:image" content="" />
  <meta property="og:image:secure_url" content="" />
  <meta property="og:image:width" content="32" />
  <meta property="og:image:height" content="32" />
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="" />

  <!-- Fix IOS zoom to input on focus -->
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no , maximum-scale=1.0, user-scalable=no" /> -->
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />
  <meta content="true" name="HandheldFriendly" />
  <meta content="width" name="MobileOptimized" />
  <meta content="yes" name="apple-mobile-web-app-capable" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="it-rating" content="" />
  <meta name="theme-color" content="#ffffff">

  <!-- [if IE]>
  <meta http-equiv="X-UA-Compatible" content="IE = edge" />
  <![endif] -->

  <link rel="canonical" href="">
  <link rel="icon" type="image/png" href="<?= base_url() ?>assets/themes/default/favicons/favicon.png" />
  <link rel="manifest" href="<?= base_url() ?>assets/themes/default/manifest.json" />
  <!-- inject:splash screens -->
  <link rel="apple-touch-startup-image"
    media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)"
    href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-1242x2688.png" />
  <link rel="apple-touch-startup-image"
    media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)"
    href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-828x1792.png" />
  <link rel="apple-touch-startup-image"
    media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)"
    href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-1125x2436.png" />
  <link rel="apple-touch-startup-image"
    media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3)"
    href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-1242x2208.png" />
  <link rel="apple-touch-startup-image"
    media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)"
    href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-750x1334.png" />
  <link rel="apple-touch-startup-image"
    media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)"
    href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-640x1136.png" />
  <link rel="apple-touch-startup-image"
    media="(device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2)"
    href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-1620x2160.png" />
  <link rel="apple-touch-startup-image"
    media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)"
    href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-2048x2732.png" />
  <link rel="apple-touch-startup-image"
    media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)"
    href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-1668x2388.png" />
  <link rel="apple-touch-startup-image"
    media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)"
    href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-1668x2224.png" />
  <link rel="apple-touch-startup-image"
    media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)"
    href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-1536x2048.png" />
  <!-- endinject:splash screens -->

  <!-- inject:font preload -->
  <!-- endinject:font preload -->

  <link rel="stylesheet" href="<?= base_url() ?>assets/themes/default/css/app.min.css" />
  <!-- [if lt IE 9]>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
  <![endif]            -->
  

</head>
<body class="auth-page <?=$this->renderSection('bobyClass') ?>">
  <div class="wrapper">
    <?= $this->include('auth/auth-pages-header') ?>
      <?= $this->renderSection('main') ?>
    <?= $this->include('auth/auth-pages-footer') ?>
  </div>
<script>
		var SITEURL = "<?= base_url() ?>";
</script>
<?= $this->renderSection('pageScripts') ?>
<script src="<?= base_url() ?>assets/themes/default/js/vendor.js"></script>
<script src="<?= base_url() ?>assets/themes/default/js/main.js"></script>

</body>
</html>
