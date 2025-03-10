	<?= $this->setData(['orders' => $bodyInjuryOrders, 'tabName' => 'bodyInjury'])->include('parts/cases/orders_offcanvas') ?>
	<?= $this->setData(['orders' => $disabilityClaimOrders, 'tabName' => 'disabilityClaim'])->include('parts/cases/orders_offcanvas') ?>
	<?= $this->setData(['orders' => $medicalMalpracticeOrders, 'tabName' => 'medicalMalpractice'])->include('parts/cases/orders_offcanvas') ?>
	<?= $this->setData(['orders' => $workersCompensationOrders, 'tabName' => 'workersCompensation'])->include('parts/cases/orders_offcanvas') ?>