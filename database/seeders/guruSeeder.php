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
        guruModel::insert(
            [
                [
                    'nama' => 'Mikaela Kusjanto',
                    'id_jurusan' => 4,
                ],
                [
                    'nama' => 'Nadia Putri',
                    'id_jurusan' => 1,
                ],
                [
                    'nama' => 'Rizky Ramadhan',
                    'id_jurusan' => 1,
                ],
                [
                    'nama' => 'Citra Ayu Pranajawa Wibrado',
                    'id_jurusan' => 1,
                ],
                [
                    'nama' => 'Dimas Saputra',
                    'id_jurusan' => 2,
                ],
                [
                    'nama' => 'Aulia Rahmawati',
                    'id_jurusan' => 2,
                ],
                [
                    'nama' => 'Rangga Pratama',
                    'id_jurusan' => 2,
                ],
                [
                    'nama' => 'Vina Oktaviani',
                    'id_jurusan' => 2,
                ],
                [
                    'nama' => 'Ilham Maulana',
                    'id_jurusan' => 3,
                ],
                [
                    'nama' => 'Salsa Nabila',
                    'id_jurusan' => 3,
                ],
                [
                    'nama' => 'Bagas Firmansyah',
                    'id_jurusan' => 3,
                ],
                [
                    'nama' => 'Anisa Safitri',
                    'id_jurusan' => 3,
                ],
                [
                    'nama' => 'Fahri Ramadhan',
                    'id_jurusan' => 4,
                ],
                [
                    'nama' => 'Dinda Maharani',
                    'id_jurusan' => 1,
                ],
                [
                    'nama' => 'Rafi Kurniawan',
                    'id_jurusan' => 4,
                ],
                [
                    'nama' => 'Bella Aprilia',
                    'id_jurusan' => 4,
                ],
                [
                    'nama' => 'Farhan Akbar',
                    'id_jurusan' => 5,
                ],
                [
                    'nama' => 'Tiara Anindya',
                    'id_jurusan' => 5,
                ],
                [
                    'nama' => 'Gilang Permana',
                    'id_jurusan' => 5,
                ],
                [
                    'nama' => 'Nabila Khairunnisa',
                    'id_jurusan' => 5,
                ],
            ]
        );
    }
}
