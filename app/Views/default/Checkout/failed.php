<?= $this->extend('template/layout') ?>
<?= $this->section('content') ?>
    <?= $this->section('extra-css') ?>
    <?= $this->endSection() ?>
    <section>
	<div class="container" style="padding-top: 120px;">
		<div style="padding: 50px;">
		<h1>Order failed</h1>

		<p>If you would like to edit this page you will find it located at:</p>

		<pre><code>/app/Views/default/checkout/failed.php</code></pre>
		</div>
	</div>
    </section>
    <?= $this->section('extra-js') ?>
    <?= $this->endSection() ?>
<?= $this->endSection() ?>