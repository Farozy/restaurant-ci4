<?php if (!empty($menu)) : ?>
    <?php foreach ($menu as $row) : ?>
        <div class="all <?= $row->categoryName ?> col col-lg-2 mb-3 grid-item--width2">
            <div class="box position-relative">
                <div class="img-box">
                    <img src="<?= base_url('uploads/images/menu') . '/' . $row->image ?>"
                         alt="" data-action="zoom">
                </div>
                <i class="fas fa-info-circle"
                   style="position: absolute; right: 3px; top: 55%; z-index: 1; cursor: pointer; color: aqua; font-size: 10px;"
                   title="Detail"
                   onclick="detail(<?= $row->id ?>)"></i>
                <div style="padding: 7px 15px;">
                    <a class="font-weight-bold"
                       style="font-size: 12px;text-align: justify; line-height: 22px; margin-top: -5px;">
                        <?= $row->name ?>
                    </a>
                </div>
                <?php $stockColor ?>
                <?php if ($row->stock >= 10) : ?>
                    <?php $stockColor = 'primary' ?>
                <?php elseif ($row->stock >= 5 && $row->stock < 10) : ?>
                    <?php $stockColor = 'warning' ?>
                <?php elseif ($row->stock > 0 && $row->stock < 5) : ?>
                    <?php $stockColor = 'danger' ?>
                <?php else: ?>
                    <?php $stockColor = 'dark' ?>
                <?php endif; ?>
                <button class="btn btn-<?= $stockColor ?> btn-sm btn-block btnOrder<?= $row->id ?>" <?= intval($row->stock) === 0 ? 'disabled' : '' ?>
                        onclick="handleOrder(<?= $row->id ?>)"
                        style="position: absolute; bottom: 0;">
                    <?php if (intval($row->stock) !== 0) : ?>
                        <i class="fas fa-cart-plus"></i> Pesan
                    <?php else: ?>
                        <i class="fas fa-times-circle"></i> Kosong
                    <?php endif; ?>
                </button>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<script>
    $(function () {
        let menu = <?= json_encode($menu); ?>

        $.map(menu, function (e) {
            if (jQuery.inArray(e.id, orders) !== -1) {
                $(`.btnOrder${e.id}`).attr('disabled', true);
                $(`.btnOrder${e.id}`).css('cursor', 'not-allowed');
                $(`.btnOrder${e.id}`).html("<i class='fas fa-check'><i/>");
            }
        })
    })
</script>
