<?php

require __DIR__.'/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet;
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Template Kelas');

$sheet->mergeCells('A1:C1');
$sheet->setCellValue('A1', 'TEMPLATE IMPORT DATA KELAS');
$sheet->getStyle('A1')->applyFromArray([
    'font' => [
        'name' => 'Cambria',
        'bold' => true,
        'size' => 18,
        'color' => ['argb' => Color::COLOR_BLACK],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
]);
$sheet->getRowDimension(1)->setRowHeight(26);

$sheet->mergeCells('A2:C2');
$sheet->setCellValue('A2', 'Silakan isi data di bawah ini sesuai format yang tersedia.');
$sheet->getStyle('A2')->applyFromArray([
    'font' => [
        'name' => 'Cambria',
        'italic' => true,
        'size' => 11,
        'color' => ['argb' => 'FF4B5563'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
]);
$sheet->getRowDimension(2)->setRowHeight(22);

$headers = ['nama', 'id_jurusan'];
$sheet->fromArray([$headers], null, 'A4');

$headerStyle = [
    'font' => [
        'name' => 'Cambria',
        'bold' => true,
        'size' => 11,
        'color' => ['argb' => Color::COLOR_WHITE],
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['argb' => 'FF1F4E78'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => 'FFB7B7B7'],
        ],
    ],
];

$sheet->getStyle('A4:B4')->applyFromArray($headerStyle);
$sheet->getRowDimension(4)->setRowHeight(22);

$sampleRows = [
    ['XI RPL 1', 'RPL'],
    ['XII TKJ 2', 'TKJ'],
];

$sheet->fromArray($sampleRows, null, 'A5');

$bodyStyle = [
    'font' => [
        'name' => 'Cambria',
        'size' => 11,
        'color' => ['argb' => 'FF1F1F1F'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_LEFT,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => 'FFB7B7B7'],
        ],
    ],
];

$sheet->getStyle('A5:B6')->applyFromArray($bodyStyle);

for ($row = 5; $row <= 6; $row++) {
    $sheet->getRowDimension($row)->setRowHeight(22);
}

$sheet->setCellValue('A8', 'Catatan');
$sheet->getStyle('A8')->applyFromArray([
    'font' => [
        'name' => 'Cambria',
        'bold' => true,
        'size' => 11,
        'color' => ['argb' => 'FF1F1F1F'],
    ],
]);

$sheet->mergeCells('A8:C8');
$sheet->setCellValue('A9', 'id_jurusan diisi dengan kode jurusan yang ada pada tabel tb_jurusan.');

$sheet->getStyle('A9')->applyFromArray([
    'font' => [
        'name' => 'Cambria',
        'size' => 11,
        'color' => ['argb' => 'FF1F1F1F'],
    ],
]);

$sheet->getColumnDimension('A')->setWidth(26);
$sheet->getColumnDimension('B')->setWidth(20);
$sheet->getColumnDimension('C')->setWidth(18);

$sheet->getStyle('A1:C9')->getFont()->setName('Cambria');

$writer = new Xlsx($spreadsheet);
$writer->save(__DIR__.'/../public/assets/static/template/kelas-import-template.xlsx');
