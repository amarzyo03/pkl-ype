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
$sheet->setTitle('Template DUDI');

$sheet->mergeCells('A1:E1');
$sheet->setCellValue('A1', 'TEMPLATE IMPORT DATA DUDI');
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

$sheet->mergeCells('A2:E2');
$sheet->setCellValue('A2', 'Isi informasi mitra pada kolom yang tersedia.');
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

$headers = ['nama', 'bidang_usaha', 'alamat', 'telepon', 'email'];
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

$sheet->getStyle('A4:E4')->applyFromArray($headerStyle);
$sheet->getRowDimension(4)->setRowHeight(22);

$sampleRows = [
    ['PT Contoh Teknologi', 'Teknologi Informasi', 'Jl. Merdeka No. 10', '0215551234', 'info@contoh.test'],
    ['CV Mitra Industri', 'Manufaktur', 'Jl. Industri No. 5', '0225556789', 'kontak@mitra.test'],
];

$sheet->fromArray($sampleRows, null, 'A5');
$sheet->getStyle('A5:E6')->applyFromArray([
    'font' => [
        'name' => 'Cambria',
        'size' => 11,
        'color' => ['argb' => 'FF1F1F1F'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_LEFT,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => 'FFB7B7B7'],
        ],
    ],
]);

for ($row = 5; $row <= 6; $row++) {
    $sheet->getRowDimension($row)->setRowHeight(30);
}

$sheet->mergeCells('A8:E8');
$sheet->setCellValue('A8', 'Catatan: nama wajib diisi dan dipakai untuk mencocokkan data saat import.');
$sheet->getStyle('A8')->applyFromArray([
    'font' => [
        'name' => 'Cambria',
        'size' => 11,
        'color' => ['argb' => 'FF1F1F1F'],
    ],
    'alignment' => [
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
    ],
]);
$sheet->getRowDimension(8)->setRowHeight(30);

foreach (['A' => 28, 'B' => 26, 'C' => 36, 'D' => 18, 'E' => 32] as $column => $width) {
    $sheet->getColumnDimension($column)->setWidth($width);
}

$sheet->getStyle('A1:E8')->getFont()->setName('Cambria');

$writer = new Xlsx($spreadsheet);
$writer->save(__DIR__.'/../public/assets/static/template/dudi-import-template.xlsx');
