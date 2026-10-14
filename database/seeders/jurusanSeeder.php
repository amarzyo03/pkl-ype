<?php

namespace Database\Seeders;

use App\Models\jurusanModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class jurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        jurusanModel::insert([
            [
                'kode' => 'akt',
                'nama' => 'akuntansi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode' => 'mpk',
                'nama' => 'manajemen perkantoran',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode' => 'bsr',
                'nama' => 'bisnis retail',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode' => 'tkj',
                'nama' => 'teknik komputer dan jaringan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode' => 'tkr',
                'nama' => 'teknik kendaraan ringan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
