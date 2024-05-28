<div class="filters-content scroll">
    <div class="grid row showMenu justify-content-lg-start justify-content-center ml-1" style="padding-bottom: 13rem;">
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
    </div>
    <div class="row grid resultMenu justify-content-lg-start justify-content-center ml-1"></div>
</div>

<script>
    function detail(id) {
        setAjax("<?= route_to('detailCashier') ?>", 'post', {id}, function (response) {
            $('.viewModal').html(response);
            $('#detailModal').modal({
                backdrop: "static"
            });
            $('#detailModal').modal('show');
        })
    }

    function handleOrder(id) {
        setAjax("<?= route_to('getMenuCashier') ?>", 'post', {id}, function (response) {
            $('.imageOrder').hide();
            orders.push(response.id)
            $('.btnCheckOrder').show();

            let sell;
            if (parseInt(response.discount) === 0) {
                countPrice.push(response.sell)
                sell = response.sell
            } else {
                const discount = (parseInt(response.discount) / 100) * parseInt(response.sell)
                const price = response.sell - discount;
                countPrice.push(price)
                sell = price;
            }

            let resultPrice = 0;
            $.map(countPrice, function (e) {
                resultPrice += parseInt(e)
            })

            $('.subtotal').val(formatRupiah(resultPrice.toString()))

            if (orders.length > 0) {
                $('.detail_order').css('height', '596px');
            }

            if (orders.length > 3) {
                $('.showOrder').css('width', '100%')
                $('.showOrder').css('height', '370px')
                $('.showOrder').css('overflow-x', 'hidden');
                $('.showOrder').css('overflow-y', 'scroll');
            }

            $(`.btnOrder${response.id}`).attr('disabled', true);
            $(`.btnOrder${response.id}`).css('cursor', 'not-allowed');
            $(`.btnOrder${response.id}`).html("<i class='fas fa-check'><i/>");

            $('.showOrder').append(viewOrder(
                response.id, response.image, response.name, amount, response.stock, sell.toString()
            ))
        })
    }

    function viewOrder(id, image, name, amount, stock, sell) {
        return `<div class="row order${id}">
                <div class="col-3 d-none d-md-inline text-center orderImg${id} detail_image_menu">
                        <img src="<?= base_url('uploads/images/menu'); ?>/${image}">
                    <input type="hidden" name="menu_id[]" value="${id}">
                </div>
                <div class="col text-left mb-3">
                    <button type="button" title="Hapus Pesanan" class="detail_button_delete" onclick="orderDelete(${id})">
                        <span aria-hidden="true"><i class="fas fa-trash-alt text-danger " style="font-size: 14px;"></i></span>
                    </button>
                    <div class="detail_name_menu">${name}</div>
                    <input type="text" class="form-control detail_request_menu" name="request[]" placeholder="Permintaan">
                    <div style="display: flex; justify-content: space-between; align-items: end;">
                            <span class="input-group-btn detail_minus_menu">
                                <button type="button" class="btn btn-danger btn-xs btn-number${id} btn-minus${id}" data-field="jumlah" onclick="handleCount(${id}, 'minus', ${stock})" disabled title="Min. 1">
                                    <span class="fas fa-minus"></span>
                                </button>
                            </span>
                            <input name="amount[]" class="text-center font-weight-bold form-control form-control-sm amount${id}" value="${amount}" style="width: 18%; height: 20px;" oninput="handleInputOrder(${id}, ${stock})" />
                            <span class="input-group-btn detail_plus_menu">
                                <button type="button" class="btn btn-success btn-xs btn-number${id} btn-plus${id}" data-field="jumlah" onclick="handleCount(${id}, 'plus', ${stock})">
                                    <span class="fas fa-plus"></span>
                                </button>
                            </span>
                        <div class="position-relative mr-2">
                            <span class="price${id} detail_price_menu">${formatRupiah(sell)}</span>
                        </div>
                        <span class="text-primary font-weight-bold total subTotal${id}"></p>
                    </div>
                </div>
            </div>
        `
    }
</script>
