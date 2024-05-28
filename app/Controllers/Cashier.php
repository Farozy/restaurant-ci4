<?php

namespace App\Controllers;

use App\Models\DistributionModel;
use App\Models\EmployeeModel;
use App\Models\MenuModel;
use App\Models\CategoryModel;
use App\Models\ProfileModel;
use CodeIgniter\Validation\Validation as ValidationAlias;
use Myth\Auth\Models\UserModel;
use Config\Services;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\Printer;

class Cashier extends BaseController
{
    private MenuModel $menu;
    private CategoryModel $category;
    private ProfileModel $profile;
    private UserModel $user;
    private EmployeeModel $employee;
    private DistributionModel $distribution;
    protected ValidationAlias $validation;

    public function __construct()
    {
        $this->menu = new MenuModel();
        $this->category = new CategoryModel();
//        $this->transaction = new TransaksiModel();
        $this->profile = new ProfileModel();
        $this->user = new UserModel();
        $this->employee = new EmployeeModel();
        $this->distribution = new DistributionModel();
        $this->validation = Services::validation();
    }

    public function index()
    {
        $menu = $this->menu->getMenu();
        $nama = $this->profile->where('id', 1)->first();

        $categoryId = [];
        foreach ($menu as $row) {
            $categoryId[] = $row->category_id;
        }

        $data = [
            'title' => 'cashier',
            'category' => $this->category->findAll(),
            'menu' => $this->menu->getMenu(),
            'categoryId' => $categoryId,
            'name' => !empty($nama) ? $nama : 'Restoran',
            'address' => $this->profile->where('id', 2)->first(),
            'district' => $this->profile->where('id', 3)->first(),
            'regency' => $this->profile->where('id', 4)->first(),
            'phone' => $this->profile->where('id', 5)->first(),
            'logo' => $this->profile->where('id', 6)->first(),
        ];

        return view('cashier/index', $data);
    }

    function buatBaris1Kolom($kolom1)
    {
        // Mengatur lebar setiap kolom (dalam unit karakter)
        $lebar_kolom_1 = 42;

        // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
        $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);

        // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
        $kolom1Array = explode("\n", $kolom1);

        // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
        $jmlBarisTerbanyak = count($kolom1Array);

        // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
        $hasilBaris = array();

        // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
        for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

            // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
            $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");

            // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
            $hasilBaris[] = $hasilKolom1;
        }

        // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
        return implode("", $hasilBaris) . "\n";
    }

    function buatBaris3Kolom($kolom1, $kolom2, $kolom3)
    {
        // Mengatur lebar setiap kolom (dalam unit karakter)
        $lebar_kolom_1 = strlen($kolom1) < 4 ? 2 : 6;
        $lebar_kolom_2 = strlen($kolom2) == 0 ? 19 : 28;
        if (strlen($kolom2) == 0) {
            $lebar_kolom_3 = 15;
        } else {
            $lebar_kolom_3 = 10;
        }
        // $lebar_kolom_3 = strlen($kolom2) > 19 ? 10 : 10;

        // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
        $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
        $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
        $kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);

        // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
        $kolom1Array = explode("\n", $kolom1);
        $kolom2Array = explode("\n", $kolom2);
        $kolom3Array = explode("\n", $kolom3);

        // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
        $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array));

        // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
        $hasilBaris = array();

        // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
        for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

            // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
            $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
            // memberikan rata kanan pada kolom 3 dan 4 karena akan kita gunakan untuk harga dan total harga
            $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ", STR_PAD_RIGHT);

            $hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ", STR_PAD_LEFT);

            // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
            $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3;
        }

        // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
        return implode("", $hasilBaris) . "\n";
    }

    public function printPemeriksa()
    {
        if ($this->request->isAjax()) {

            $kode = $this->request->getVar('kode');

            $transaksi = $this->transaksi->getTrans($kode);
            $nama = $this->profile->where('id', 1)->first();

            $profile = CapabilityProfile::load("simple");
            $connector = new WindowsPrintConnector("web_coding");
            $printer = new Printer($connector, $profile);

            $printer->initialize();
            $printer->selectPrintMode(printer::MODE_FONT_B);

            if (!empty($nama)) {
                $printer->text($this->buatBaris1Kolom("            " . $nama['nilai_profile']));
            } else {
                $printer->text($this->buatBaris1Kolom("                Restoran"));
            }
            $printer->text($this->buatBaris1Kolom("        Nguling Pasuruan Jawa Timur"));
            $printer->text($this->buatBaris1Kolom("             Telp: 1234567890"));
            $printer->text("\n");

            $printer->text($this->buatBaris1Kolom("No#      : " . $kode));
            $printer->text($this->buatBaris1Kolom("Tanggal  : " . date('d/m/Y') . ' | ' . date('H:i:s')));

            $printer->text($this->buatBaris1Kolom('=========================================='));

            $jumlah = 0;
            foreach ($transaksi as $row) {
                $jumlah += $row['jumlah'];

                $printer->text($this->buatBaris3Kolom("$row[jumlah]", $row['nama_menu'], $row['nama_kategori']));
                $printer->text("\n");
            }


            $printer->text($this->buatBaris1Kolom('=========================================='));

            $printer->text($this->buatBaris3Kolom("$jumlah", 'Jumlah Item : ' . $jumlah, ''));

            $printer->feed(2);
            $printer->cut();
            $printer->close();

            $msg = [
                'data' => $transaksi
            ];

            return $this->response->setJSON($msg);
        } else {
            return redirect()->back()->with('error', 'Forbidden');
        }
    }

    public function printTagihan()
    {
        if ($this->request->isAjax()) {

            $kode = $this->request->getVar('kode');

            $transaksi = $this->transaksi->getTrans($kode);
            $karyawan = $this->karyawan->find(user()->karyawan_id);
            $nama = $this->profile->where('id', 1)->first();

            $profile = CapabilityProfile::load("simple");
            $connector = new WindowsPrintConnector("web_coding");
            $printer = new Printer($connector, $profile);

            $printer->initialize();
            $printer->selectPrintMode(printer::MODE_FONT_B);

            if (!empty($nama)) {
                $printer->text($this->buatBaris1Kolom("            " . $nama['nilai_profile']));
            } else {
                $printer->text($this->buatBaris1Kolom("                Restoran"));
            }
            $printer->text($this->buatBaris1Kolom("        Nguling Pasuruan Jawa Timur"));
            $printer->text($this->buatBaris1Kolom("             Telp: 1234567890"));
            $printer->text("\n");

            $printer->text($this->buatBaris1Kolom("No#      : " . $kode));
            $printer->text($this->buatBaris1Kolom("Tanggal  : " . date('d/m/Y') . ' | ' . date('H:i:s')));
            $printer->text($this->buatBaris1Kolom("cashier    : " . $karyawan['nama_karyawan']));


            $printer->text($this->buatBaris1Kolom('=========================================='));

            $subTotal = 0;
            $diskon = 0;
            foreach ($transaksi as $row) {
                $subTotal = $row['sub_total'];

                if ($row['diskon'] != 0) {
                    $diskon = ($row['diskon'] / 100) * $row['harga_jual'];
                }

                $printer->text($this->buatBaris3Kolom("$row[jumlah]", $row['nama_menu'], number_format($row['jumlah'] * ($row['harga_jual'] - $diskon), 0, ',', '.')));
            }


            $printer->text($this->buatBaris1Kolom('=========================================='));
            $printer->text($this->buatBaris3Kolom("Total:", "", number_format($subTotal), 0, ',', '.'));
            $printer->text("\n");

            $printer->text($this->buatBaris1Kolom("                Terima Kasih"));

            $printer->feed(2);
            $printer->cut();
            $printer->close();

            $msg = [
                'data' => $transaksi
            ];

            return $this->response->setJSON($msg);
        } else {
            return redirect()->back()->with('error', 'Forbidden');
        }
    }

    public function bayarPesanan($kode)
    {
        $nama = $this->profile->where('id', 1)->first();

        $transaksi = $this->transaksi->getTrans($kode);
        $meja = $this->transaksi->where('status_meja', 1)->groupBy('kode_transaksi')->findAll();

        $idTransaksi = [];
        foreach ($transaksi as $row) {
            $idTransaksi[] = $row['id_transaksi'];
        }

        $data = [
            'title' => 'Bayar',
            'transaction' => $transaksi,
            'id_transaksi' => $idTransaksi,
            'kode_transaksi' => $kode,
            'dist' => $this->dist->findAll(),
            'meja' => $meja,
            'tanggal' => date('d') . '-' . bulan(date('m')) . '-' . date('Y'),
            'nama' => !empty($nama) ? $nama : 'Restoran',
            'alamat' => $this->profile->where('id', 2)->first(),
            'kecamatan' => $this->profile->where('id', 3)->first(),
            'kabupaten' => $this->profile->where('id', 4)->first(),
            'no_telp' => $this->profile->where('id', 5)->first(),
            'logo' => $this->profile->where('id', 6)->first(),
        ];

        return view('cashier/bayarPesanan', $data);
    }

    public function getDist()
    {
        if ($this->request->isAjax()) {

            $input = $this->request->getVar();
            $value = $this->request->getVar('value');
            $countTrans = $this->transaksi->getTrans($input['kode_transaksi']);

            $dist = $this->dist->find($value);

            $msg = [
                'data' => $dist,
                'countTrans' => count($countTrans)
            ];

            return $this->response->setJSON($msg);
        } else {
            return redirect()->back()->with('error', 'Forbidden');
        }
    }

    public function getStatusMeJa()
    {
        if ($this->request->isAjax()) {

            $value = $this->request->getVar('value');

            $trans = $this->transaksi->where('no_meja', $value)->where('status_meja', 1)->first();

            $msg = [
                'data' => $trans
            ];

            return $this->response->setJSON($msg);
        } else {
            return redirect()->back()->with('error', 'Forbidden');
        }
    }

    public function getNoMeja()
    {
        if ($this->request->isAjax()) {

            $input = $this->request->getVar();
            $transaksi = $this->transaksi->where('kode_transaksi', $input['kode_transaksi'])->groupBy('kode_transaksi')->get()->getRowArray();

            $this->transaksi->set('status_meja', 0);
            $this->transaksi->where('kode_transaksi', $input['kode_transaksi']);
            $this->transaksi->update();

            $msg = [
                'icon' => 'success',
                'title' => 'No. meja ' . $transaksi['no_meja'] . ' berhasil dikosongkan'
            ];

            return $this->response->setJSON($msg);
        } else {
            return redirect()->back()->with('error', 'Forbidden');
        }
    }

    public function pembayaranPesanan()
    {
        if ($this->request->isAjax()) {

            $input = $this->request->getVar();
            $countReq = count($input['id_transaksi']);
            $trans = $this->transaksi->where('kode_transaksi', $input['kode_transaksi'])->get()->getRowArray();
            $dist = $this->dist->find($input['distribusi_id']);

            for ($i = 0; $i < $countReq; $i++) {
                $data = [
                    'customer' => $input['customer'],
                    'request' => $input['request'][$i],
                    'sub_total' => $trans['sub_total'] + $dist['harga_distribusi'],
                    'distribusi_id' => $input['distribusi_id'],
                    'no_meja' => !empty($input['no_meja']) ? $input['no_meja'] : 0,
                    'status_meja' => !empty($input['no_meja']) ? 1 : 0,
                    'bayar' => str_replace('.', '', $input['bayar']),
                    'kembalian' => str_replace('.', '', $input['kembalian']),
                    'status_transaksi' => 1,
                    'status_bayar' => 1,
                ];

                $this->transaksi->update(['id_transaksi' => $input['id_transaksi'][$i]], $data);
            }

            $msg = [
                'data' => $input['kode_transaksi']
            ];

            return $this->response->setJSON($msg);
        } else {
            return redirect()->back()->with('error', 'Forbidden');
        }
    }

    public function printStruk($kode)
    {

        $transaksi = $this->transaksi->getTrans($kode);
        $karyawan = $this->karyawan->find(user()->karyawan_id);
        $trans = $this->transaksi->get_trans($kode);
        $nama = $this->profile->where('id', 1)->first();

        $profile = CapabilityProfile::load("simple");
        $connector = new WindowsPrintConnector("web_coding");
        $printer = new Printer($connector, $profile);

        $printer->initialize();
        $printer->selectPrintMode(printer::MODE_FONT_B);

        if (!empty($nama)) {
            $printer->text($this->buatBaris1Kolom("            " . $nama['nilai_profile']));
        } else {
            $printer->text($this->buatBaris1Kolom("                Restoran"));
        }
        $printer->text($this->buatBaris1Kolom("        Nguling Pasuruan Jawa Timur"));
        $printer->text($this->buatBaris1Kolom("             Telp: 1234567890"));
        $printer->text("\n");

        $printer->text($this->buatBaris1Kolom("No#          : " . $kode));
        $printer->text($this->buatBaris1Kolom("Tanggal      : " . date('d/m/Y') . ' | ' . date('H:i:s')));
        $printer->text($this->buatBaris1Kolom("cashier        : " . $karyawan['nama_karyawan']));
        $printer->text($this->buatBaris1Kolom("Pelanggan    : " . $trans['customer']));
        if ($trans['nama_distribusi'] == 'Dine In') {
            $printer->text($this->buatBaris1Kolom("Distribution   : " . $trans['nama_distribusi']));
            $printer->text($this->buatBaris1Kolom("No. Meja     : " . $trans['no_meja']));
        }

        $printer->text($this->buatBaris1Kolom('=========================================='));

        $diskon = 0;
        $subTotal = 0;
        $bayar = 0;
        $kembalian = 0;
        foreach ($transaksi as $row) {
            $subTotal = $row['sub_total'];
            $bayar = $row['bayar'];
            $kembalian = $row['kembalian'];

            if ($row['diskon'] != 0) {
                $diskon = ($row['diskon'] / 100) * $row['harga_jual'];
            }

            $printer->text($this->buatBaris3Kolom("$row[jumlah]", $row['nama_menu'], number_format($row['jumlah'] * ($row['harga_jual'] - $diskon), 0, ',', '.')));
        }

        $printer->text($this->buatBaris1Kolom('=========================================='));
        $printer->text($this->buatBaris3Kolom("", "Sub total", number_format($subTotal - $trans['harga_distribusi']), 0, ',', '.'));
        $printer->text($this->buatBaris3Kolom("", "Pajak PPN (10%)", number_format($trans['harga_distribusi']), 0, ',', '.'));
        $printer->text($this->buatBaris3Kolom("", "Total", number_format($subTotal), 0, ',', '.'));
        $printer->text("\n");

        $printer->text($this->buatBaris1Kolom("Metode           :   " . 'Tunai'));
        $printer->text($this->buatBaris1Kolom("Bayar            :   " . number_format($bayar), 0, ',', '.'));
        $printer->text($this->buatBaris1Kolom("Kembalian        :   " . number_format($kembalian), 0, ',', '.'));
        $printer->text("\n");

        $printer->text($this->buatBaris1Kolom("                Terima Kasih"));

        $printer->feed(2);
        $printer->cut();
        $printer->close();

        session()->setFlashdata('success', 'Transaction pembayaran berhasil');
        return redirect()->to('cashier');
    }
}
