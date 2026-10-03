<?php

namespace App\Imports;

use App\Models\dudiModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DudiImport implements ToCollection, WithHeadingRow
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

            dudiModel::updateOrCreate(
                ['nama' => $nama],
                [
                    'bidang_usaha' => $this->nullableString($row['bidang_usaha'] ?? null),
                    'alamat' => $this->nullableString($row['alamat'] ?? null),
                    'telepon' => $this->nullableString($row['telepon'] ?? null),
                    'email' => $this->nullableString($row['email'] ?? null),
                ]
            );
        }
    }

    private function nullableString(mixed $value): ?string
    {
        $value = trim((string) ($value ?? ''));

        return $value === '' ? null : $value;
    }
}
