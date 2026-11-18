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
            // SKK
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
            // AKT
            [
                'kode' => 'akk',
                'nama' => 'Akuntasi Keuangan',
                'jenis' => 'produktif',
            ],
            [
                'kode' => 'kak',
                'nama' => 'Komputer Akuntansi',
                'jenis' => 'produktif',
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
            ],
            // MPK
            [
                'kode' => 'padu',
                'nama' => 'Pengelolaan Administrasi Umum',
                'jenis' => 'produktif',
            ],
            [
                'kode' => 'tpk',
                'nama' => 'Teknologi Perkantoran',
                'jenis' => 'produktif',
            ],
            [
                'kode' => 'pkr',
                'nama' => 'Pengelolaan Kearsipan',
                'jenis' => 'produktif',
            ],
            [
                'kode' => 'ktk',
                'nama' => 'Komunikasi tempat kerja',
                'jenis' => 'produktif',
            ],
            // BSR
            [
                'kode' => 'kbs',
                'nama' => 'Komunikasi Bisnis',
                'jenis' => 'produktif',
            ],
            [
                'kode' => 'pbr',
                'nama' => 'Pengelolaan Bisnis Ritel',
                'jenis' => 'produktif',
            ],
            [
                'kode' => 'mrt',
                'nama' => 'Marketing',
                'jenis' => 'produktif',
            ],
            [
                'kode' => 'vmc',
                'nama' => 'Visual Merchandising',
                'jenis' => 'produktif',
            ],
            [
                'kode' => 'csr',
                'nama' => 'Customer Service',
                'jenis' => 'produktif',
            ],
            // TKJ
            [
                'kode' => 'asj',
                'nama' => 'Administrasi Sistem Jaringan',
                'jenis' => 'produktif',
            ],
            [
                'kode' => 'kjr',
                'nama' => 'Keamanan Jaringan',
                'jenis' => 'produktif',
            ],
            [
                'kode' => 'tjkn',
                'nama' => 'Teknologi Jaringan Kabel dan Nirkabel',
                'jenis' => 'produktif',
            ],
            [
                'kode' => 'pkpj',
                'nama' => 'Pemasangan dan konfigurasi Perangkat Jaringan',
                'jenis' => 'produktif',
            ],
            [
                'kode' => 'ppj',
                'nama' => 'Perencanaan dan Pengalamatan Jaringan',
                'jenis' => 'produktif',
            ],
            // TKR
            [
                'kode' => 'sskr',
                'nama' => 'Sistem Sasis Kendaraan Ringan',
                'jenis' => 'produktif',
            ],
            [
                'kode' => 'sekr',
                'nama' => 'Sistem Engine Kendaraan Ringan',
                'jenis' => 'produktif'
            ],
            [
                'kode' => 'skkr',
                'nama' => 'Sistem Kelistrikan Kendaraan Ringan',
                'jenis' => 'produktif'
            ]
        ]);
    }
}
