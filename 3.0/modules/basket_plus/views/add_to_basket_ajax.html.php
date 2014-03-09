<?php defined("SYSPATH") or die("No direct script access.") ?>
<div id="g-add-to-basket">
	<div id="basketThumb">
		<img src="<?= $item->thumb_url()?>" title="<?= $item->title?>" alt="<?= $item->title?>" />
	</div>
	<b><?= t("Choose print format and number of prints") ?></b>
	<div id="basketForm">
		<?= $form ?>
	</div>
</div>