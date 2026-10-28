<?php

namespace Database\Seeders;

use App\Models\tugasModel;
use Illuminate\Database\Seeder;

class tugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        tugasModel::insert(
            [
                'id_guru' => 1,
                'tanggal' => now()->toDateString(),
                'judul' => 'tkj',
                'deskripsi' => 'kerjakan hal 10',
                'file' => '2026-10-28_kktkj.pdf',
            ]
        );
    }
}
