<?= $this->include('templates/cashier/header'); ?>
<div class="menu">
    <div class="card-body">
        <section class="food_section">
            <div class="container_menu">
                <div class="font-dancing h1 font-weight-bold text-center">
                    Daftar Menu
                </div>
                <?= $this->include('cashier/category') ?>
                <?= $this->include('cashier/menu') ?>
            </div>
        </section>
    </div>
</div>
<?= $this->include('cashier/detail_order') ?>
<div class="viewModal"></div>

<?= $this->include('templates/cashier/footer') ?>

<script>
    let orders = [];
    let counts = {};
    let amount = 1;
    let total = [];
    let countItems = [];
    let orderTotal = 0;
    let countPrice = [];

    $(function () {
        // checkResolution();
        $('.search').keyup(function () {
            const value = $(this).val();

            setAjax("<?= route_to('searchMenuCashier') ?>", 'post', {search: value, countItems}, function (response) {
                const menu = response.menu;

                if (value !== '') {
                    if (menu.length > 0) {
                        $('.filters_menu li').addClass('disabled');
                        $('.filters_menu li').removeClass('active');
                        $('.showMenu').hide();
                        $('.resultMenu').show();
                        $('.resultMenu').html(response.data);
                    } else {
                        $('.showMenu').hide();
                        $('.resultMenu').show();
                        $('.resultMenu').html(`
                            <div class="col-md-6 offset-3">
                                <h3><i class="fas fa-times fa-spin text-danger"></i> Data menu tidak ditemukan <i class="fas fa-times fa-spin text-danger"></i></h3>
                            </div>
                        `)
                    }
                } else {
                    $('.showMenu').show();
                    $('.resultMenu').hide();
                    $('.filters_menu li').removeClass('disabled');
                    $('.filters_menu li:first').addClass('active');
                }
            })
        })

        $('.imgOrder').click(function () {
            $('.search').focus();
        })
    })
</script>