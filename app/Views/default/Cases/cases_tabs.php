<?php
    $pager = isset($pager) && !empty($pager) ? $pager : NULL;
    $tabName = isset($tabName) && !empty($tabName) ? $tabName : 'bodyInjury';
?>

<div class="tab-pane fade <?= $tabName === 'bodyInjury' ? 'show active' : '' ?>" id="bodyInjury" role="tabpanel" aria-labelledby="bodyInjury-tab">
    <?= $this->setData(['orders' => $bodyInjuryOrders, 'pager' => $pager, 'tabName' => 'bodyInjury'])->include('parts/cases/orders_table') ?>
</div>

<div class="tab-pane fade <?= $tabName === 'disabilityClaim' ? 'show active' : '' ?>" id="disabilityClaim" role="tabpanel" aria-labelledby="disabilityClaim-tab">
    <?= $this->setData(['orders' => $disabilityClaimOrders, 'pager' => $pager, 'tabName' => 'disabilityClaim'])->include('parts/cases/orders_table') ?>
</div>

<div class="tab-pane fade <?= $tabName === 'medicalMalpractice' ? 'show active' : '' ?>" id="medicalMalpractice" role="tabpanel" aria-labelledby="medicalMalpractice-tab">
    <?= $this->setData(['orders' => $medicalMalpracticeOrders, 'pager' => $pager, 'tabName' => 'medicalMalpractice'])->include('parts/cases/orders_table') ?>
</div>

<div class="tab-pane fade <?= $tabName === 'workersCompensation' ? 'show active' : '' ?>" id="workersCompensation" role="tabpanel" aria-labelledby="workersCompensation-tab">
    <?= $this->setData(['orders' => $workersCompensationOrders, 'pager' => $pager, 'tabName' => 'workersCompensation'])->include('parts/cases/orders_table') ?>
</div>
