<?php

namespace Database\Seeders;

use App\Models\kelasModel;
use Illuminate\Database\Seeder;

class kelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        kelasModel::insert([
            'nama' => 'xi tkj-1',
            'id_jurusan' => 'tkj',
        ]);
    }
}
