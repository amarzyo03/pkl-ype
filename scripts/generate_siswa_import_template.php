<?php

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Template Siswa');

$sheet->mergeCells('A1:G1');
$sheet->setCellValue('A1', 'TEMPLATE IMPORT DATA SISWA');
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

$sheet->mergeCells('A2:G2');
$sheet->setCellValue('A2', 'Silakan isi data di bawah ini sesuai format yang tersedia. Status: 1 = aktif, 0 = inactive.');
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

$headers = ['nis', 'nisn', 'nama', 'kelas', 'username', 'password', 'status'];
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

$sheet->getStyle('A4:G4')->applyFromArray($headerStyle);
$sheet->getRowDimension(4)->setRowHeight(22);

$sampleRows = [
    ['NIS-001', 'NISN-001', 'Budi Santoso', 'XII IPA 1', 'budisantoso', 'secret123', null],
    ['NIS-002', 'NISN-002', 'Siti Nurhaliza', 'XII IPA 2', 'sitinurhaliza', 'secret123', null],
];

$sheet->fromArray($sampleRows, null, 'A5');

$sheet->setCellValueExplicit('G5', 1, DataType::TYPE_NUMERIC);
$sheet->setCellValueExplicit('G6', 0, DataType::TYPE_NUMERIC);

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

$sheet->getStyle('A5:G6')->applyFromArray($bodyStyle);

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

$sheet->mergeCells('A8:G8');
$sheet->setCellValue('A9', '1 = Aktif');
$sheet->setCellValue('A10', '0 = Inactive');
$sheet->setCellValue('A11', 'kolom yang tersedia: nis, nisn, nama, kelas, username, password, status');

$sheet->getStyle('A9:A11')->applyFromArray([
    'font' => [
        'name' => 'Cambria',
        'size' => 11,
        'color' => ['argb' => 'FF1F1F1F'],
    ],
]);

$sheet->getColumnDimension('A')->setWidth(18);
$sheet->getColumnDimension('B')->setWidth(18);
$sheet->getColumnDimension('C')->setWidth(24);
$sheet->getColumnDimension('D')->setWidth(18);
$sheet->getColumnDimension('E')->setWidth(22);
$sheet->getColumnDimension('F')->setWidth(18);
$sheet->getColumnDimension('G')->setWidth(14);

$sheet->getStyle('A1:G11')->getFont()->setName('Cambria');

$writer = new Xlsx($spreadsheet);
$writer->save(__DIR__ . '/../public/assets/static/template/siswa-import-template.xlsx');
