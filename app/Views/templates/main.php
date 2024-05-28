<?= $this->include('templates/header'); ?>

<?= $this->include('templates/navbar'); ?>
<?php
$requestUri = $_SERVER['REQUEST_URI'];

$segments = explode('/', trim($requestUri, '/'));

$uri = !empty($segments[0]) ? $segments[0] : '';
?>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> <?= ucwords(str_replace('/', ' ', $title)) ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                        href="/<?= $uri ?>"><?= ucwords(str_replace('/', ' ', $title)) ?></a></li>
                            <?php if (!empty($sub_title)) : ?>
                                <li class="breadcrumb-item active"><?= $sub_title ?></li>
                            <?php endif; ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <?= $this->renderSection('content'); ?>
            </div>
        </div>
    </div>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
<?= $this->include('templates/footer') ?>