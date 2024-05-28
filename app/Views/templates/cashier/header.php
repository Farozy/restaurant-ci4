<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!-- Site Metas -->
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <link rel="shortcut icon" href="https://www.seekpng.com/png/full/474-4741429_food-up-arrow-flat-icon.png"
          type="image/png">
    <title> Kasir </title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('templates/cashier'); ?>/css/bootstrap.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <!-- Custom styles for this template -->
    <link href="<?= base_url('templates/cashier'); ?>/css/style.css" rel="stylesheet"/>
    <!-- responsive style -->
    <link href="<?= base_url('templates/cashier'); ?>/css/responsive.css" rel="stylesheet"/>
    <!-- Toast -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css"/>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <!-- DataTables -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://datatables.net/release-datatables/media/css/dataTables.bootstrap4.css">
    <link rel="stylesheet"
          href="https://datatables.net/release-datatables/extensions/FixedColumns/css/fixedColumns.bootstrap4.css">

    <!-- jQery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <!-- popper js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <!-- bootstrap js -->
    <script src="<?= base_url('templates/cashier'); ?>/js/bootstrap.js"></script>
    <script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
    <!-- Toast -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Datatables-->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://datatables.net/release-datatables/media/js/jquery.dataTables.js"></script>
    <script src="https://datatables.net/release-datatables/media/js/dataTables.bootstrap4.js"></script>
    <script src="https://datatables.net/release-datatables/extensions/FixedColumns/js/dataTables.fixedColumns.js"></script>

</head>
<?php
$requestUri = $_SERVER['REQUEST_URI'];

$segments = explode('/', trim($requestUri, '/'));
$segment = !empty($segments[1]) ? $segments[1] : '';

$uri = !empty($segments[0]) ? $segment : '';
?>
<body class="sub_page">
<div class="hero_area">
    <div class="bg-box">
        <img src="http://liondesign.com.au/wp-content/uploads/2016/07/Portfolio-Ab-Food-Background-768x432.jpg" alt="">
    </div>
    <header class="header_section">
        <div class="container">
            <nav class="navbar navbar-expand-lg custom_nav-container ">
                <a class="navbar-brand" href="<?= base_url('cashier'); ?>">
                        <span>
                            <?= $name['description'] ?? 'Restoran'; ?>
                        </span>
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class=""> </span>
                </button>

                <?php if (isset($name['description'])) : ?>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <?php else : ?>
                    <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarSupportedContent">
                        <?php endif; ?>
                        <ul class="navbar-nav ">
                            <li class="nav-item <?= $uri === '' ? 'active' : ''; ?> <?= $uri === 'checking-order' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?= base_url('cashier'); ?>">Menu</a>
                            </li>
                            <li class="nav-item <?= $uri === 'profile' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?= route_to('profileCashier') ?>">Profile</a>
                            </li>
                            <li class="nav-item <?= $uri === 'password' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?= route_to('changePasswordCashier') ?>">Password</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" id="logout">Logout</a>
                            </li>
                        </ul>
                        <div class="text-center d-inline d-sm-none">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar search" type="text"
                                       placeholder="Pencarian..."
                                       style="background: #E9ECEF; border-top-left-radius: 5px; border-bottom-left-radius: 5px;">
                            </div>
                        </div>
                    </div>
                    <div class="text-center d-none d-sm-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar search" type="text"
                                   placeholder="Pencarian..."
                                   style="background: #E9ECEF; border-top-left-radius: 5px; border-bottom-left-radius: 5px;">
                        </div>
                    </div>
            </nav>
        </div>
    </header>
</div>
