<?= $this->extend('templates/main'); ?>

<?= $this->section('content'); ?>

<div class="viewData">
	<?= $this->include('menu/data'); ?>
</div>
<div class="viewModal"></div>

<?= $this->endSection(); ?>
