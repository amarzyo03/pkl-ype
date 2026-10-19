<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\dudiModel;

class dudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        dudiModel::insert([
            [
                'nama' => 'DUDI1',
                'alamat' => 'Jl. Contoh Alamat No. 123, Kota Contoh',
                'telp' => '081234567890',
                'pic' => 'DUDI PIC 1',
                'id_jurusan' => 1,
                'id_guru' => 1,
            ],
            [
                'nama' => 'DUDI2',
                'alamat' => 'Jl. Contoh Alamat No. 456, Kota Contoh',
                'telp' => '081234567891',
                'pic' => 'DUDI PIC 2',
                'id_jurusan' => 2,
                'id_guru' => 1,
            ],
            [
                'nama' => 'DUDI3',
                'alamat' => 'Jl. Contoh Alamat No. 789, Kota Contoh',
                'telp' => '081234567892',
                'pic' => 'DUDI PIC 3',
                'id_jurusan' => 3,
                'id_guru' => 1,
            ],
            [
                'nama' => 'DUDI4',
                'alamat' => 'Jl. Contoh Alamat No. 101, Kota Contoh',
                'telp' => '081234567893',
                'pic' => 'DUDI PIC 4',
                'id_jurusan' => 4,
                'id_guru' => 1,
            ],
            [
                'nama' => 'DUDI5',
                'alamat' => 'Jl. Contoh Alamat No. 202, Kota Contoh',
                'telp' => '081234567894',
                'pic' => 'DUDI PIC 5',
                'id_jurusan' => 5,
                'id_guru' => 1,
            ],
        ]);
    }
}
