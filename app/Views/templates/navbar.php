<?php
$requestUri = $_SERVER['REQUEST_URI'];

$segments = explode('/', trim($requestUri, '/'));

$uri = !empty($segments[0]) ? $segments[0] : '';
$uri2 = !empty($segments[1]) ? $segments[1] : '';
?>
<nav class="main-header navbar navbar-expand-md navbar-dark navbar-dark">
    <div class="container">
        <a href="#" class="navbar-brand">
            <img src="https://www.seekpng.com/png/full/474-4741429_food-up-arrow-flat-icon.png"
                 class="brand-image img-circle elevation-3" style="opacity: .8" alt="image">
            <span class="brand-text font-weight-light">Restoran</span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <?php if (in_groups('admin')) : ?>
                        <a href="<?= route_to('indexAdmin') ?>" class="nav-link <?= strtolower($uri) === 'admin' ? 'active' : '' ?>">Dashboard</a>
                    <?php elseif (in_groups('cashier')) : ?>
                        <a href="<?= route_to('cashierIndex') ?>" class="nav-link">Dashboard</a>
                    <?php endif; ?>
                </li>
                <?php if (in_groups('admin')) : ?>
                    <li class="nav-item dropdown <?= strtolower($uri) === 'category' ? 'active' : '' ?>">
                        <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false" class="nav-link dropdown-toggle">Data Master</a>
                        <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                            <li><a href="<?= route_to('indexCategory') ?>" class="dropdown-item <?= strtolower($uri) === 'category' ? 'active' : '' ?>">Kategori</a></li>
                            <li><a href="<?= route_to('indexDistribution') ?>" class="dropdown-item <?= strtolower($uri) === 'distribution' ? 'active' : '' ?>">Distribusi</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="<?= route_to('indexMenu') ?>" class="nav-link <?= strtolower($uri) === 'menu' ? 'active' : '' ?>">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= route_to('indexEmployee') ?>" class="nav-link <?= strtolower($uri) === 'employee' ? 'active' : '' ?>">Karyawan</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= route_to('indexTransaction') ?>" class="nav-link <?= strtolower($uri) === 'transaction' ? 'active' : '' ?>">Transaksi</a>
                    </li>
                    <li class="nav-item dropdown <?= strtolower($uri) === 'report' ? 'active' : '' ?>">
                        <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false" class="nav-link dropdown-toggle">Laporan</a>
                        <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                            <li><a href="<?= route_to('reportTransaction'); ?>" class="dropdown-item <?= $uri2 === 'transaction' ? 'active' : '' ?>">Transaksi</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown <?= strtolower($uri) === 'profile' ? 'active' : '' ?> <?= strtolower($uri) === 'user' ? 'active' : '' ?> <?= strtolower($uri) === 'role' ? 'active' : '' ?> <?= strtolower($uri) === 'permission' ? 'active' : '' ?>">
                        <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false" class="nav-link dropdown-toggle">Pengaturan</a>
                        <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                            <li><a href="<?= route_to('indexProfile'); ?>" class="dropdown-item <?= strtolower($uri) === 'profile' ? 'active' : '' ?>">Profile</a></li>
                            <li><a href="<?= route_to('indexUser') ?>" class="dropdown-item <?= strtolower($uri) === 'user' ? 'active' : '' ?>">User</a></li>
                            <li><a href="<?= route_to('indexRole') ?>" class="dropdown-item <?= strtolower($uri) === 'role' ? 'active' : '' ?>">Role</a></li>
                            <li><a href="<?= route_to('indexPermission') ?>" class="dropdown-item <?= strtolower($uri) === 'permission' ? 'active' : '' ?>">Permission</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a type="button" id="logout" class="nav-link">Logout</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>