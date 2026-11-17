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
$sheet->setTitle('Template Guru');

$sheet->setCellValue('A1', 'TEMPLATE IMPORT DATA GURU');
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

$sheet->setCellValue('A2', 'Isi nama guru.');
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

$headers = ['nama'];
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

$sheet->getStyle('A4:A4')->applyFromArray($headerStyle);
$sheet->getRowDimension(4)->setRowHeight(22);

$sheet->fromArray([
    ['Nama Guru Contoh'],
    ['Guru Contoh Dua'],
], null, 'A5');
$sheet->getStyle('A5:A6')->applyFromArray([
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
]);

for ($row = 5; $row <= 6; $row++) {
    $sheet->getRowDimension($row)->setRowHeight(22);
}

$sheet->setCellValue('A8', 'File hanya memerlukan nama guru.');
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

$sheet->getColumnDimension('A')->setWidth(30);

$sheet->getStyle('A1:A8')->getFont()->setName('Cambria');

$writer = new Xlsx($spreadsheet);
$writer->save(__DIR__.'/../public/assets/static/template/guru-import-template.xlsx');
