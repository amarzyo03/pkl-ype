<?php

namespace Database\Seeders;

use App\Models\kelasModel;
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
            'username' => 'siswa1',
            'password' => bcrypt('siswa1'),
            'status' => 'active',
        ]);
    }
}
