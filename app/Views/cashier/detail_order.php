<div class="detail_order">
    <?= form_open(route_to('checkOrderCashier')) ?>
    <?= csrf_field(); ?>
    <div style="background: #f8f9fc; border-radius: 20px;">
        <div class="font-weight-bold pb-2 text-center h2 font-dancing">Detail Pesanan</div>
        <div class="mt-3 showOrder"></div>
        <div class="imageOrder text-center">
            <img src="https://cdn3.iconfinder.com/data/icons/shopping-and-ecommerce-29/90/empty_cart-512.png"
                 alt="" class="imgOrder">
            <div class="text-center">
                <div class="h5 font-weight-bold" style="color: #1c65e8">Pesanan Masih Kosong</div>
            </div>
        </div>
        <div class="px-2 btnCheckOrder detail_check_order">
            <button type="submit" class="btn btn-success btn-sm btn-block btnCheckOrder">
                <i class="fas fa-file-alt"></i> Cek Pesanan
            </button>
        </div>
    </div>
    <?= form_close(); ?>
</div>

<script>
    const handleInputOrder = (id, stock) => {
        const amount = parseInt($(`.amount${id}`).val());

        if (isNaN(amount)) {
            $(`.amount${id}`).val(1);
        } else if (amount >= stock) {
            $(`.amount${id}`).val(stock);
            $(`.btn-plus${id}`).attr('disabled', true);
            $(`.btn-minus${id}`).attr('disabled', false);
        } else if (amount < stock) {
            $(`.btn-plus${id}`).attr('disabled', false);
        }
    }

    const handleCount = (id, type, stock) => {
        const count = parseInt($(`.amount${id}`).val());

        if (type === 'minus') {
            $(`.amount${id}`).val(count - 1);
            const amount = parseInt($(`.amount${id}`).val());

            if (amount < stock) {
                $(`.btn-plus${id}`).attr('disabled', false);
                $(`.btn-plus${id}`).removeAttr('title');
            }

            if (amount === 1) {
                $(`.btn-minus${id}`).attr('disabled', true);
                $(`.btn-minus${id}`).attr('title', 'Min. 1');
            }
        } else {
            $(`.amount${id}`).val(count + 1)
            const amount = parseInt($(`.amount${id}`).val());

            if (amount < stock) {
                $(`.btn-minus${id}`).attr('disabled', false);
                $(`.btn-minus${id}`).removeAttr('title');
            } else {
                $(`.btn-plus${id}`).attr('disabled', true);
                $(`.btn-plus${id}`).attr('title', 'Max. Stok');
            }

            if (amount === stock) {
                $(`.btn-minus${id}`).attr('disabled', false);
                $(`.btn-minus${id}`).removeAttr('title');
            }
        }
    }

    const orderDelete = (id) => {
        const orderAmount = parseInt($(`.amount${id}`).val());
        const countAmount = parseInt($('.countAmount').val())

        orders = $.grep(orders, function (value) {
            return parseInt(value) !== id;
        })

        $(`.order${id}`).remove();
        $(`.btnOrder${id}`).attr('disabled', false);
        $(`.btnOrder${id}`).css('cursor', 'pointer');
        $(`.btnOrder${id}`).html("<i class='fas fa-cart-plus'></i> Pesan");

        if (orders.length > 1 && (orders.length - 1) < 5) {
            $('.showOrder').css('width', '')
            $('.showOrder').css('height', '')
            $('.showOrder').css('overflow-x', '');
            $('.showOrder').css('overflow-y', '');
        }

        if (orders.length === 0) {
            $('.imageOrder').show();
            $('.btnCekPesanan').remove();
            $('.countAmount').val('');
            $('.subtotal').val('');
            $('.btnCheckOrder').hide();
            $('.detail_order').css('height', '');
        } else {
            $('.countAmount').val(countAmount - orderAmount)
        }
    }
</script>