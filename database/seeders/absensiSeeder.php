<?php

namespace Database\Seeders;

use App\Models\absensiModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class absensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        absensiModel::create(
            [
                'id_siswa' => 1,
                'tanggal' => '2026-10-29',
                'status' => 'hadir',
                'foto' => '1_20261029131442_udZKom4u.png',
                'keterangan' => 'semangats'
            ]
        );
    }
}
