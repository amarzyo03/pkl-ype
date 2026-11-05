<?php

namespace Database\Seeders;

use App\Models\guruModel;
use Illuminate\Database\Seeder;

class guruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        guruModel::create([
            'nama' => 'mikaela kusjanto',
            'id_jurusan' => 1,
        ]);
    }
}
