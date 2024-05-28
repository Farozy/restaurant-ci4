<?php

namespace App\Controllers;

use App\Models\ProfileModel;
use App\Models\TransactionModel;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class Report extends BaseController
{
    private TransactionModel $transaction;
    private ProfileModel $profile;
    private Spreadsheet $spreadsheet;

    public function __construct()
    {
        $this->transaction = new TransactionModel();
        $this->profile = new ProfileModel();
        $this->spreadsheet = new Spreadsheet();
    }

    public function index()
    {
        return redirect()->back();
    }

    public function Transaction()
    {
        return view('report/transaction', ['title' => 'Transaksi']);
    }

    public function getTransactionDate()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $input = $this->request->getVar();
        $fromDate = format_year($input['fromDate']);
        $toDate = format_year($input['toDate']);
        $transaction = $this->transaction->getTransactionByDate($fromDate, $toDate);

        return $this->response->setJSON($transaction);
    }

    public function printTransaction($fromDate, $toDate)
    {

        $name = $this->profile->where('id', 1)->first();
        $fDate = format_year($fromDate);
        $tDate = format_year($toDate);
        $transaction = $this->transaction->getTransactionByDate($fDate, $tDate);

        $codeCount = [];
        foreach ($transaction as $tran) {
            $code = $tran->code;
            if (!isset($codeCount[$code])) {
                $codeCount[$code] = 0;
            }
            $codeCount[$code]++;
        }

        $data = [
            'title' => 'Laporan Transaksi',
            'transaction' => $transaction,
            'codeCount' => $codeCount,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'date' => date('d') . '-' . month(date('m')) . '-' . date('Y'),
            'name' => !empty($name) ? $name : 'Restoran',
            'address' => $this->profile->where('id', 2)->first(),
            'district' => $this->profile->where('id', 3)->first(),
            'regency' => $this->profile->where('id', 4)->first(),
            'phone' => $this->profile->where('id', 5)->first(),
            'logo' => $this->profile->where('id', 6)->first(),
        ];

        return view('report/print_transaction', $data);
    }

    public function excelTransaction($fromDate, $toDate)
    {
        $fDate = format_year($fromDate);
        $tDate = format_year($toDate);
        $transaction = $this->transaction->getTransactionByDate($fDate, $tDate);

        $sheet = $this->spreadsheet->getActiveSheet();

        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle' => Border::BORDER_THIN],
                'right' => ['borderStyle' => Border::BORDER_THIN],
                'bottom' => ['borderStyle' => Border::BORDER_THIN],
                'left' => ['borderStyle' => Border::BORDER_THIN]
            ]
        ];

        $style_row = [
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle' => Border::BORDER_THIN],
                'right' => ['borderStyle' => Border::BORDER_THIN],
                'bottom' => ['borderStyle' => Border::BORDER_THIN],
                'left' => ['borderStyle' => Border::BORDER_THIN]
            ]
        ];

        $sheet->setCellValue('A1', "Laporan Transaksi");
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(25);
        $sheet->getStyle('A1:H1')->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A1:H1')->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A1:H1')->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);

        $sheet->setCellValue('A2', "No.");
        $sheet->setCellValue('B2', "Menu");
        $sheet->setCellValue('C2', "Kategori");
        $sheet->setCellValue('D2', "Jumlah");
        $sheet->setCellValue('E2', "Tanggal");
        $sheet->setCellValue('F2', "Kasir");
        $sheet->setCellValue('G2', "Distribusi");
        $sheet->setCellValue('H2', "Subtotal");

        $sheet->getStyle('A2')->applyFromArray($style_col);
        $sheet->getStyle('B2')->applyFromArray($style_col);
        $sheet->getStyle('C2')->applyFromArray($style_col);
        $sheet->getStyle('D2')->applyFromArray($style_col);
        $sheet->getStyle('E2')->applyFromArray($style_col);
        $sheet->getStyle('F2')->applyFromArray($style_col);
        $sheet->getStyle('G2')->applyFromArray($style_col);
        $sheet->getStyle('H2')->applyFromArray($style_col);

        $sheet->getRowDimension('1')->setRowHeight(30);

        $countSql = count($transaction);
        $no = 1;
        $row = 3;
        $total = 0;
        $currentCode = '';
        $codeCount = [];

        foreach ($transaction as $tran) {
            $code = $tran->code;
            if (!isset($codeCount[$code])) {
                $codeCount[$code] = 0;
            }
            $codeCount[$code]++;
        }


        foreach ($transaction as $data) {
            $total += $data->subtotal;

            $sheet->setCellValueExplicit('A' . $row, $no++, DataType::TYPE_STRING);
            $sheet->setCellValue('B' . $row, $data->menuName);
            $sheet->setCellValue('C' . $row, $data->categoryName);
            $sheet->setCellValueExplicit('D' . $row, rupiah($data->amount), DataType::TYPE_STRING);
//            $sheet->setCellValueExplicit('H' . $row, rupiah($data->subtotal), DataType::TYPE_STRING);
            if ($data->code !== $currentCode) {
                $currentCode = $data->code;
                $sheet->mergeCells('E' . $row . ':E' . ($row + $codeCount[$currentCode] - 1));
                $sheet->setCellValue('E' . $row, format_day($data->date));
                $sheet->mergeCells('F' . $row . ':F' . ($row + $codeCount[$currentCode] - 1));
                $sheet->setCellValue('F' . $row, $data->employeeName);
                $sheet->mergeCells('G' . $row . ':G' . ($row + $codeCount[$currentCode] - 1));
                $sheet->setCellValue('G' . $row, $data->distributionName);
                $sheet->mergeCells('H' . $row . ':H' . ($row + $codeCount[$currentCode] - 1));
//                $sheet->setCellValue('H' . $row, ($codeCount[$currentCode] * $data->subtotal));
                $sheet->setCellValueExplicit('H' . $row, rupiah($codeCount[$currentCode] * $data->subtotal), DataType::TYPE_STRING);
            }

            $sheet->getStyle('A' . $row)->applyFromArray($style_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A' . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
            $sheet->getStyle('B' . $row)->applyFromArray($style_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('C' . $row)->applyFromArray($style_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('D' . $row)->applyFromArray($style_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F' . $row)->applyFromArray($style_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
            $sheet->getStyle('E' . $row)->applyFromArray($style_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G' . $row)->applyFromArray($style_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('H' . $row)->applyFromArray($style_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('H' . $row)->applyFromArray($style_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('H' . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

            $row++;
        }

        $sheet->setCellValue('A' . ($countSql + 3), "Total");
        $sheet->mergeCells('A' . ($countSql + 3) . ':G' . ($countSql + 3));
        $sheet->getStyle('A' . ($countSql + 3))->getFont()->setBold(true);
        $sheet->getStyle('A' . ($countSql + 3))->getFont()->setSize(14);
        $sheet->getStyle('A' . ($countSql + 3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A' . ($countSql + 3))->getFont()->setBold(true);
        $sheet->getStyle('A' . ($countSql + 3) . ':F' . ($countSql + 3))->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A' . ($countSql + 3) . ':F' . ($countSql + 3))->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);

        $sheet->setCellValue('H' . ($countSql + 3), rupiah($total));
        $sheet->getStyle('H' . ($countSql + 3))->applyFromArray($style_row)->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('H' . ($countSql + 3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(17);

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_DEFAULT);

        $strFilename = sprintf('%s_%s', 'Laporan_transaki_', date('YmdHis'));
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $strFilename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $writer->save('php://output');
        die;
    }
}
