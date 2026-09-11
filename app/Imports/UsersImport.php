<?php

namespace App\Imports;

use App\Models\userModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow
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

            if ($nama === '' || $username === '') {
                continue;
            }

            $role = strtolower(trim((string) ($row['role'] ?? 'siswa')));
            $statusValue = $row['status'] ?? null;

            if (!in_array($role, ['admin', 'guru', 'siswa'], true)) {
                $role = 'siswa';
            }

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
                } elseif (!in_array($status, ['active', 'inactive'], true)) {
                    $status = 'active';
                }
            }

            $password = trim((string) ($row['password'] ?? ''));

            $payload = [
                'nama' => $nama,
                'username' => $username,
                'role' => $role,
                'status' => $status,
            ];

            $payload['password'] = Hash::make($password !== '' ? $password : 'password123');

            userModel::updateOrCreate(
                ['username' => $username],
                $payload
            );
        }
    }
}
