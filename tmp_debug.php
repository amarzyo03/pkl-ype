<?php
require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Illuminate\Support\Facades\Facade::setFacadeApplication($app);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DebugImport implements ToArray, WithHeadingRow
{
    public function array(array $array): void {}

    public function headingRow(): int
    {
        return 1;
    }
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->fromArray([
    ['nama', 'username', 'password', 'role', 'status'],
    ['Budi Santoso', 'budisantoso', 'secret123', 'admin', 1],
    ['Siti Nurhaliza', 'sitinurhaliza', 'secret123', 'guru', 0],
], null, 'A1');

$writer = new Xlsx($spreadsheet);
$writer->save('tmp-debug.xlsx');

$rows = Excel::toArray(new DebugImport(), 'tmp-debug.xlsx');
var_dump($rows[0]);

unlink('tmp-debug.xlsx');
