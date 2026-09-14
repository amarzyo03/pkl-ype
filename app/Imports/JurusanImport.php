<?php

namespace App\Imports;

use App\Models\jurusanModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JurusanImport implements ToCollection, WithHeadingRow
{
    public function headingRow(): int
    {
        return 4;
    }

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $kode = trim((string) ($row['kode'] ?? ''));
            $nama = trim((string) ($row['nama'] ?? ''));

            if ($kode === '' || $nama === '') {
                continue;
            }

            jurusanModel::updateOrCreate(
                ['kode' => $kode],
                [
                    'kode' => $kode,
                    'nama' => $nama,
                ]
            );
        }
    }
}
