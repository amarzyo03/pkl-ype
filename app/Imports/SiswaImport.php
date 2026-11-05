<?php

namespace App\Imports;

use App\Models\kelasModel;
use App\Models\siswaModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    public function headingRow(): int
    {
        return 4;
    }

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $nis = trim((string) ($row['nis'] ?? ''));
            $nisn = trim((string) ($row['nisn'] ?? ''));
            $nama = trim((string) ($row['nama'] ?? ''));
            $kelas = trim((string) ($row['kelas'] ?? ''));

            if ($nis === '' && $nisn === '' && $nama === '' && $kelas === '') {
                continue;
            }

            if ($nis === '' || $nisn === '' || $nama === '' || $kelas === '') {
                throw ValidationException::withMessages([
                    'file' => 'Setiap baris siswa harus memiliki NIS, NISN, nama, dan kelas.',
                ]);
            }

            $kelasRecord = kelasModel::query()
                ->where(function (Builder $query) use ($kelas): void {
                    $query->where('nama', $kelas);

                    if (ctype_digit($kelas)) {
                        $query->orWhereKey((int) $kelas);
                    }
                })
                ->first();

            if ($kelasRecord === null) {
                throw ValidationException::withMessages([
                    'file' => "Kelas '{$kelas}' tidak ditemukan di data kelas.",
                ]);
            }

            $statusValue = $row['status'] ?? null;

            if ($statusValue === null || $statusValue === '') {
                $status = 'active';
            } elseif (is_bool($statusValue)) {
                $status = $statusValue ? 'active' : 'inactive';
            } elseif (is_numeric($statusValue)) {
                $status = (int) $statusValue === 1 ? 'active' : 'inactive';
            } else {
                $status = strtolower(trim((string) $statusValue));

                if ($status === '1') {
                    $status = 'active';
                } elseif ($status === '0') {
                    $status = 'inactive';
                } elseif (! in_array($status, ['active', 'inactive'], true)) {
                    $status = 'active';
                }
            }

            $payload = [
                'nis' => $nis,
                'nisn' => $nisn,
                'nama' => $nama,
                'id_kelas' => $kelasRecord->id,
                'status' => $status,
            ];

            siswaModel::updateOrCreate(
                ['nis' => $nis],
                $payload
            );
        }
    }
}
