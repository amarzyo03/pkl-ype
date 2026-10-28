<?php

namespace Database\Seeders;

use App\Models\pendaftaranModel;
use Illuminate\Database\Seeder;

class pendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        pendaftaranModel::insert(
            [
                'id_siswa' => 1,
                'id_dudi' => 1,
                'status' => 'disetujui',
            ]
        );
    }
}
