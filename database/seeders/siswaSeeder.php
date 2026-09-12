<?php

namespace Database\Seeders;

use App\Models\siswaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class siswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        siswaModel::insert([
            [
                'nis'           => '123',
                'nisn'          => '00123',
                'nama'          => 'siswa1',
                'kelas'         => 'x tkj-1',
                'username'      => 'siswa1',
                'password'      => bcrypt('siswa1'),
                'status'        => 'active',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]
        ]);
    }
}
