<?php if (!empty($category)) : ?>
    <ul class="filters_menu mt-3">
        <?php if (count($category) > 1) : ?>
            <li class="active all" data-filter="*">Semua</li>
        <?php endif; ?>
        <?php foreach ($category as $row) : ?>
            <?php if (in_array($row->id, $categoryId)) : ?>
                <li data-filter=".<?= $row->name ?>"><?= ucwords($row->name) ?></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>