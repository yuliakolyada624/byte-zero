<?= $this->extend('template/layout') ?>
<?= $this->section('content') ?>
    <?= $this->section('extra-css') ?>
    <?= $this->endSection() ?>
    <section>
	<div class="container" style="padding-top: 120px;">
		<div style="padding: 50px;">
			<h1>Thank you</h1>

			<?php
			if($booking_id){
				echo "Your booking id $booking_id</br>";
			}
			?>
			Thank you for booking with us! Your booking has been received and is being processed.
			We will send you an email confirmation shortly with your booking details.
		</div>
	</div>
    </section>
    <?= $this->section('extra-js') ?>
    <?= $this->endSection() ?>
<?= $this->endSection() ?>