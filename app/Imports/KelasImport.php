<?php

namespace App\Imports;

use App\Models\jurusanModel;
use App\Models\kelasModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KelasImport implements ToCollection, WithHeadingRow
{
    public function headingRow(): int
    {
        return 4;
    }

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $nama = trim((string) ($row['nama'] ?? ''));
            $idJurusan = $row['id_jurusan'] ?? null;

            if ($nama === '' || $idJurusan === null || $idJurusan === '') {
                continue;
            }

            $jurusan = jurusanModel::where('kode', trim((string) $idJurusan))->first();
            if (! $jurusan) {
                continue;
            }

            $payload = [
                'nama' => $nama,
                'id_jurusan' => $jurusan->id,
            ];

            kelasModel::updateOrCreate(
                ['nama' => $nama],
                $payload
            );
        }
    }
}
