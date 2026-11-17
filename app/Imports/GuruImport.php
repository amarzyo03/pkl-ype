<?php

namespace App\Imports;

use App\Models\guruModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToCollection, WithHeadingRow
{
    public function headingRow(): int
    {
        return 4;
    }

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $nama = trim((string) ($row['nama'] ?? ''));

            if ($nama === '') {
                continue;
            }

            $guru = guruModel::withTrashed()->firstOrNew(['nama' => $nama]);

            if ($guru->trashed()) {
                $guru->restore();
            } else {
                $guru->save();
            }
        }
    }
}
