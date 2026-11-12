<?php

namespace Database\Seeders;

use App\Models\jurusanModel;
use Illuminate\Database\Seeder;

class jurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        jurusanModel::insert(
            [
                [
                    'kode' => 'akt',
                    'nama' => 'akuntansi',
                ],
                [
                    'kode' => 'bsr',
                    'nama' => 'bisnis retail / bisnis digital',
                ],
                [
                    'kode' => 'mpk',
                    'nama' => 'manajemen perkantoran',
                ],
                [
                    'kode' => 'tkj',
                    'nama' => 'teknik komputer dan jaringan',
                ],
                [
                    'kode' => 'tkr',
                    'nama' => 'teknik kendaraan ringan',
                ],
            ]
        );
    }
}
