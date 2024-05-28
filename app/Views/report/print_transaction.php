<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print Report Transaction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Passion+One:wght@400;700;900&display=swap');

        @page {
            margin: 1cm 2cm 1cm 2cm
        }

        .name_restaurant {
            font-family: "Passion One", sans-serif;
            font-weight: 400;
            font-style: normal;
            font-size: 40px;
            text-align: center;
        }

        .title {
            font-family: 'Open Sans', sans-serif;
            font-weight: bold;
            text-align: center;
            padding-top: 5px;
            font-size: 22px;
        }

        .tblReportTransaction thead tr {
            text-align: center
        }
    </style>
</head>
<body>
<div style="border: 2px solid black; padding: 0 10px;">
    <div class="row border border-bottom border-dark">
        <div class="col-3">
            <img src="<?= base_url('uploads/images/icon'); ?>/<?= strtolower($logo['description']) ?>" alt=""
                 style="width: 70px; height: 60px;">
        </div>
        <div class="col-7 col-offset-2">
            <div class="name_restaurant">
                <?= $name['description'] ?? ''; ?>
            </div>

            <div class="text-center pb-1" style="margin-top: -10px; font-size: 12px">
                <?= $address['description'] ?? ''; ?> -
                <?= $district['description'] ?? ''; ?> -
                <?= $regency['description'] ?? ''; ?>
            </div>
        </div>
    </div>
    <div>
        <div class="title">
            <?= $title ?>
        </div>
        <div class="row">
            <div class="col-6 text-start">
                <small class="text-sm">Dari Tanggal : <?= $fromDate ?></small>
            </div>
            <div class="col-6 text-end">
                <small>Sampai Tanggal : <?= $toDate ?></small>
            </div>
        </div>
        <div>
            <table class="table table-bordered table-striped table-sm tblReportTransaction" width="100%">
                <thead>
                <tr>
                    <th width="3%">No.</th>
                    <th>Menu</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Kasir</th>
                    <th>Distribusi</th>
                    <th>Subotal</th>
                </tr>
                </thead>
                <tbody>
                <?php $total = 0; ?>
                <?php $currentCode = '' ?>
                <?php foreach ($transaction as $x => $row) : ?>
                    <?php $total += $row->subtotal ?>
                    <tr class="page">
                        <td class="text-center"><?= $x + 1; ?></td>
                        <td><?= $row->menuName ?></td>
                        <td class="text-center"><?= $row->categoryName ?></td>
                        <td class="text-center"><?= $row->amount ?></td>
                        <?php if ($row->code !== $currentCode) : ?>
                            <?php $currentCode = $row->code ?>
                            <td class="text-center align-middle" rowspan="<?= $codeCount[$currentCode] ?>"><?= format_day($row->date) ?></td>
                            <td class="align-middle"
                                rowspan="<?= $codeCount[$currentCode] ?>"><?= $row->employeeName ?></td>
                            <td class="align-middle"
                                rowspan="<?= $codeCount[$currentCode] ?>"><?= $row->distributionName ?></td>
                            <td class="text-end align-middle"
                                rowspan="<?= $codeCount[$currentCode] ?>"><?= rupiah($codeCount[$currentCode] * $row->subtotal) ?></td>
                        <?php endif ?>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <th class="text-center font-weight-bold" colspan="7">Total</th>
                    <th class="text-end font-weight-bold">Rp. <?= rupiah($total) ?></th>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        window.onload = function () {
            window.print();
        }
    </script>
</body>
</html>