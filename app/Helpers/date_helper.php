<?php

function month($m = 0)
{
    $months = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ];

    if ($m !== 0) {
        return $months[$m];
    }
    return $months;
}

function short_month($m = 0)
{
    $months = [
        'Jan' => 'Jan',
        'Feb' => 'Feb',
        'Mar' => 'Mar',
        'April' => 'Apr',
        'Mei' => 'Mei',
        'Jun' => 'Jun',
        'Jul' => 'Jul',
        'Aug' => 'Agus',
        'Sep' => 'Sep',
        'Oct' => 'Okt',
        'Nov' => 'Nov',
        '12' => 'Desember',
    ];

    if ($m !== 0) {
        return $months[$m];
    }
    return $months;
}

function month_name($m = 0)
{
    $months = [
        'Januari' => '01',
        'Februari' => '02',
        'Maret' => '03',
        'April' => '04',
        'Mei' => '05',
        'Juni' => '06',
        'Juli' => '07',
        'Agustus' => '08',
        'September' => '09',
        'Oktober1' => '0',
        'November' => '11',
        'Desember' => '12',
    ];

    if ($m !== 0) {
        return $months[$m];
    }
    return $months;
}

function hari($d = 0)
{
    $hari_arr = [
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jum\'at',
        'Saturday' => 'Sabtu',
        'Sunday' => 'Minggu',
    ];

    if ($d !== 0) {
        return $hari_arr[$d];
    }
    return $hari_arr;
}

function tgl_hari($tgl)
{
    $month = month(date('m', strtotime($tgl)));
    $hari = hari(date('l', strtotime($tgl)));
    return $hari .
        ', ' .
        date('d-', strtotime($tgl)) .
        $month .
        date('-Y', strtotime($tgl));
}

function day_month($month, $year)
{
    $kalender = CAL_GREGORIAN;
    $jml_hari = cal_days_in_month($kalender, $month, $year);
    $hari_tgl = [];

    for ($i = 1; $i <= $jml_hari; $i++) {
        $tgl = $i . '-' . $month . '-' . $year;
        $hari_tgl[] = [
            'hari' => hari(date('l', strtotime($tgl))),
            'tanggal' => date('d-m-Y', strtotime($tgl)),
        ];
    }
    return $hari_tgl;
}

function format_day($date)
{
    return date('d-m-Y', strtotime($date));
}

function format_month($date)
{
    return date('m-d-Y', strtotime($date));
}

function format_year($date)
{
    return date('Y-m-d', strtotime($date));
}
