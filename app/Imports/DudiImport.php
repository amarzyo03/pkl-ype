<?php

namespace App\Imports;

use App\Models\dudiModel;
use App\Models\guruModel;
use App\Models\jurusanModel;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
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
        foreach ($rows as $rowIndex => $row) {
            $nama = trim((string) ($row['nama'] ?? ''));

            if ($nama === '') {
                continue;
            }

            $idJurusan = $this->relatedId($row['id_jurusan'] ?? null, 'id_jurusan', $rowIndex);
            $idGuru = $this->relatedId($row['id_guru'] ?? null, 'id_guru', $rowIndex);
            $alamat = $this->requiredString($row['alamat'] ?? null, 'alamat', $rowIndex);
            $telp = $this->requiredString($row['telp'] ?? null, 'telp', $rowIndex);
            $pic = $this->requiredString($row['pic'] ?? null, 'pic', $rowIndex);

            if (! jurusanModel::whereKey($idJurusan)->exists()) {
                throw ValidationException::withMessages([
                    'file' => "Jurusan dengan ID {$idJurusan} pada baris ".((int) $rowIndex + 5).' tidak ditemukan atau tidak aktif.',
                ]);
            }

            if (! guruModel::whereKey($idGuru)->exists()) {
                throw ValidationException::withMessages([
                    'file' => "Guru dengan ID {$idGuru} pada baris ".((int) $rowIndex + 5).' tidak ditemukan atau tidak aktif.',
                ]);
            }

            $dudi = dudiModel::withTrashed()->firstOrNew(['nama' => $nama]);
            $dudi->fill([
                'alamat' => $alamat,
                'telp' => $telp,
                'pic' => $pic,
                'id_jurusan' => $idJurusan,
                'id_guru' => $idGuru,
            ]);

            if ($dudi->trashed()) {
                $dudi->restore();
            } else {
                $dudi->save();
            }
        }
    }

    private function relatedId(mixed $value, string $field, int|string $rowIndex): int
    {
        $id = filter_var(trim((string) ($value ?? '')), FILTER_VALIDATE_INT);

        if ($id === false || $id < 1) {
            throw ValidationException::withMessages([
                'file' => "Kolom {$field} pada baris ".((int) $rowIndex + 5).' harus berisi ID yang valid.',
            ]);
        }

        return $id;
    }

    private function requiredString(mixed $value, string $field, int|string $rowIndex): string
    {
        $value = trim((string) ($value ?? ''));

        if ($value === '') {
            throw ValidationException::withMessages([
                'file' => "Kolom {$field} pada baris ".((int) $rowIndex + 5).' wajib diisi.',
            ]);
        }

        return $value;
    }
}
