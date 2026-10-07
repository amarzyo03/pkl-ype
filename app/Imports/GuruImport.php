<?php

namespace App\Imports;

use App\Models\guruModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
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
            $username = strtolower(trim((string) ($row['username'] ?? '')));
            $password = trim((string) ($row['password'] ?? ''));

            if ($nama === '' || $username === '') {
                continue;
            }

            $guru = guruModel::withTrashed()->firstOrNew(['username' => $username]);
            $guru->nama = $nama;

            if ($password !== '') {
                $guru->password = Hash::make($password);
            } elseif (! $guru->exists) {
                continue;
            }

            if ($guru->trashed()) {
                $guru->restore();
            }

            $guru->save();
        }
    }
}
