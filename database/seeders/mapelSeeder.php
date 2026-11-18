<?php

namespace Database\Seeders;

use App\Models\mapelModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class mapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        mapelModel::insert([
            [
                'kode' => 'bing',
                'nama' => 'Bahasa Inggris',
                'jenis' => 'skk',

            ],
            [
                'kode' => 'jwa',
                'nama' => 'Bahasa Jawa',
                'jenis' => 'skk',
            ],
            [
                'kode' => 'sej',
                'nama' => 'Sejarah',
                'jenis' => 'skk',
            ],
            [
                'kode' => 'bind',
                'nama' => 'Bahasa Indonesia',
                'jenis' => 'skk',
            ],
            [
                'kode' => 'panc',
                'nama' => 'Pendidikan Pancasila',
                'jenis' => 'skk',
            ],
            [
                'kode' => 'mtk',
                'nama' => 'Matematika',
                'jenis' => 'skk',
            ],
            [
                'kode' => 'bjep',
                'nama' => 'Bahasa Jepang',
                'jenis' => 'skk',
            ],
            [
                'kode' => 'paibp',
                'nama' => 'Pendidikan Agama Islam dan budi Pekerti',
                'jenis' => 'skk',
            ],
            [
                'kode' => 'pjok',
                'nama' => 'Pendidikan Jasmani, Olahraga dan Kesehatan',
                'jenis' => 'skk',
            ],
            [
                'kode' => 'kik',
                'nama' => 'kreativitas dan Kewirausahaan',
                'jenis' => 'skk',
            ],
            [
                'kode' => 'apjdm',
                'nama' => 'Administrasi PJDM',
                'jenis' => 'produktif',
            ],
            [
                'kode' => 'ppj',
                'nama' => 'Perpajakan',
                'jenis' => 'produktif',
            ]
        ]);
    }
}
