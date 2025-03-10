<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(1);
//dd($pager->pageSelector);
?>
<style>

</style>
<ul class="pagination">

	<?php if ($pager->hasPreviousPage()): ?>
		<li class="page-item">
			<a class="page-link" href="<?= $pager->getPreviousPage() ?>">
				<svg class="icon icon-arrow-pagination prev">
					<use href="/assets/themes/default/icon/icons/icons.svg#arrow-pagination" />
				</svg>
				<span class="text"><?= lang('Pager.previous') ?></span>
			</a>
		</li>
	<?php endif ?>
	<?php foreach ($pager->links() as $link): ?>
		<li class="page-item page" <?= $link['active'] ? 'aria-current="page"' : '' ?>>
			<a class="page-link  <?= $link['active'] ? 'active' : '' ?>"
				href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
		</li>
	<?php endforeach ?>
	<?php if ($pager->hasNextPage()): ?>
		<li class="page-item">
			<a class="page-link" href="<?= $pager->getNextPage() ?>">
				<span class="text"><?= lang('Pager.next') ?></span>
				<svg class="icon icon-arrow-pagination next">
					<use href="/assets/themes/default/icon/icons/icons.svg#arrow-pagination" />
				</svg>
			</a>
		</li>
	<?php endif ?>
</ul>

