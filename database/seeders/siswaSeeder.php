<?php

namespace Database\Seeders;

use App\Models\siswaModel;
use Illuminate\Database\Seeder;

class siswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        siswaModel::create([
            'nis' => '123',
            'nisn' => '00123',
            'nama' => 'siswa1',
            'id_kelas' => 1,
            'status' => 'active',
        ]);
    }
}
