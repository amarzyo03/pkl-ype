<?php

namespace App\Imports;

use App\Models\guruModel;
use App\Models\jurusanModel;
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
            $kodeJurusan = trim((string) ($row['kode_jurusan'] ?? ''));

            if ($nama === '' || $kodeJurusan === '') {
                continue;
            }

            $jurusan = jurusanModel::query()->where('kode', $kodeJurusan)->first();

            if ($jurusan === null) {
                continue;
            }

            $guru = guruModel::withTrashed()->firstOrNew(['nama' => $nama]);
            $guru->id_jurusan = $jurusan->id;

            if ($guru->trashed()) {
                $guru->restore();
            } else {
                $guru->save();
            }
        }
    }
}
