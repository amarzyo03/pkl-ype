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
            [
                'nama' => 'xi akt',
                'id_jurusan' => '1',
            ],
            [
                'nama' => 'xi mpk 1',
                'id_jurusan' => '2',
            ],
            [
                'nama' => 'xi mpk 2',
                'id_jurusan' => '2',
            ],
            [
                'nama' => 'xi mpk 3',
                'id_jurusan' => '2',
            ],
            [
                'nama' => 'xi mpk 4',
                'id_jurusan' => '2',
            ],
            [
                'nama' => 'xi bsr 1',
                'id_jurusan' => '3',
            ],
            [
                'nama' => 'xi bsr 2',
                'id_jurusan' => '3',
            ],
            [
                'nama' => 'xi tkj 1',
                'id_jurusan' => '4',
            ],
            [
                'nama' => 'xi tkj 2',
                'id_jurusan' => '4',
            ],
            [
                'nama' => 'xi tkj 3',
                'id_jurusan' => '4',
            ],
            [
                'nama' => 'xi tkr 1',
                'id_jurusan' => '5',
            ],
            [
                'nama' => 'xi tkr 2',
                'id_jurusan' => '5',
            ],
            [
                'nama' => 'xi tkr 3',
                'id_jurusan' => '5',
            ],
            [
                'nama' => 'xi tkr 4',
                'id_jurusan' => '5',
            ],
            [
                'nama' => 'xi tkr 5',
                'id_jurusan' => '5',
            ],
            [
                'nama' => 'xi tkr 6',
                'id_jurusan' => '5',
            ],
            [
                'nama' => 'xi tkr 7',
                'id_jurusan' => '5',
            ],
        ]);
    }
}
