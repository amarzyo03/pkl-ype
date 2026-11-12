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
        $namaSiswaPerKelas = [
            1 => [
                'Alya Putri Pratama',
                'Dimas Arya Saputra',
                'Nadia Zahra Lestari',
                'Rafi Alvaro Ramadhan',
                'Tiara Anindya Putri',
                'Fikri Maulana Akbar',
                'Citra Kirana Dewi',
                'Rizky Aditya Nugraha',
                'Nabila Syifa Azzahra',
                'Kevin Rayhan Wijaya',
            ],
            2 => [
                'Naura Safira Maharani',
                'Rangga Dwi Kurniawan',
                'Salsabila Nindya Putri',
                'Farhan Ilham Prakoso',
                'Keisya Amanda Larasati',
                'Bagas Farel Firmansyah',
                'Mutiara Dhea Anggraini',
                'Akmal Reza Pahlevi',
                'Vania Calista Permata',
                'Gilang Rafael Setiawan',
            ],
            3 => [
                'Zahra Aulia Febriani',
                'Bryan Alif Pratama',
                'Nasywa Meidina Safitri',
                'Raka Bintang Pamungkas',
                'Shania Putri Wulandari',
                'Dzaky Hafiz Maulana',
                'Celine Aurelia Maharani',
                'Reyhan Fadhil Hidayat',
                'Anindita Kayla Puspita',
                'Adrian Rizky Kurnia',
            ],
            4 => [
                'Aisyah Najwa Ramadhani',
                'Rifqi Zidan Firmansyah',
                'Meisya Talita Prameswari',
                'Naufal Abimanyu Saputra',
                'Livia Sekar Ayuningtyas',
                'Daffa Althaf Prakoso',
                'Putri Alika Rahmawati',
                'Fathan Ghani Wiratama',
                'Syakira Nabila Khairunnisa',
                'Rendy Mahesa Nugroho',
            ],
            5 => [
                'Aurel Cintya Maharani',
                'Ilham Daffa Kurniawan',
                'Nayla Humaira Safitri',
                'Rizal Fikri Ramadhan',
                'Keyla Aurellia Puspitasari',
                'Alif Ghazi Pratama',
                'Dinda Meilani Anggraini',
                'Rafiq Alfarizi Hidayat',
                'Shafira Nadhira Putri',
                'Vino Arkan Setiawan',
            ],
            6 => [
                'Tasya Kirana Lestari',
                'Raka Adhi Wijaya',
                'Ziva Callista Rahma',
                'Fauzan Naufal Akbar',
                'Aulia Nasyita Febriani',
                'Rangga Dito Pamungkas',
                'Nadine Putri Amelia',
                'Arya Fathan Prakoso',
                'Salma Azzahra Dewi',
                'Bima Alvaro Nugraha',
            ],
            7 => [
                'Intan Keisya Maharani',
                'Farel Dimas Saputra',
                'Nabila Zahra Prameswari',
                'Daffa Rizky Firmansyah',
                'Alya Meidina Puspita',
                'Rafi Zidan Kurniawan',
                'Citra Shania Wulandari',
                'Farhan Ghani Hidayat',
                'Vania Talita Permata',
                'Adrian Rayhan Setiawan',
            ],
            8 => [
                'Nadya Syifa Ramadhani',
                'Bryan Akmal Pratama',
                'Aurelia Celine Anggraini',
                'Gilang Fikri Maulana',
                'Kayla Nindya Safitri',
                'Rizky Alfarizi Pamungkas',
                'Dhea Kirana Putri',
                'Naufal Ilham Nugroho',
                'Salsabila Najwa Lestari',
                'Kevin Arkan Wijaya',
            ],
            9 => [
                'Nayla Anindya Maharani',
                'Dimas Fathan Ramadhan',
                'Meisya Aulia Pratama',
                'Rafi Althaf Firmansyah',
                'Tiara Calista Permata',
                'Dzaky Reza Hidayat',
                'Putri Syakira Anggraini',
                'Rangga Mahesa Saputra',
                'Aisyah Nadhira Puspita',
                'Vino Rafael Kurniawan',
            ],
            10 => [
                'Shania Zahra Febriani',
                'Bagas Aditya Prakoso',
                'Keisya Humaira Lestari',
                'Fikri Abimanyu Nugraha',
                'Nadia Sekar Wulandari',
                'Rizal Hafiz Setiawan',
                'Mutiara Alika Rahmawati',
                'Rendy Ghazi Pamungkas',
                'Livia Amanda Dewi',
                'Akmal Dwi Pahlevi',
            ],
            11 => [
                'Ziva Nasywa Maharani',
                'Ilham Arya Saputra',
                'Aurel Putri Prameswari',
                'Fauzan Farel Kurniawan',
                'Nadine Syifa Azzahra',
                'Raka Alif Maulana',
                'Tasya Dhea Anggraini',
                'Rifqi Rayhan Hidayat',
                'Salma Kirana Lestari',
                'Bima Rizky Firmansyah',
            ],
            12 => [
                'Celine Najwa Permata',
                'Daffa Rafael Pratama',
                'Aulia Calista Safitri',
                'Rafiq Bintang Nugroho',
                'Nabila Talita Ramadhani',
                'Fathan Dito Pamungkas',
                'Meilani Nindya Putri',
                'Rizal Ghani Setiawan',
                'Naura Anindita Puspita',
                'Alvaro Fikri Wijaya',
            ],
            13 => [
                'Syakira Meidina Maharani',
                'Farhan Zidan Kurniawan',
                'Vania Azzahra Lestari',
                'Dimas Althaf Prakoso',
                'Keyla Kirana Wulandari',
                'Akmal Hafiz Saputra',
                'Aisyah Cintya Anggraini',
                'Rangga Fadhil Nugraha',
                'Nayla Aurelia Dewi',
                'Rendy Arkan Firmansyah',
            ],
            14 => [
                'Salsabila Kayla Pratama',
                'Gilang Alfarizi Ramadhan',
                'Nasywa Putri Puspitasari',
                'Bryan Dwi Hidayat',
                'Dinda Humaira Safitri',
                'Rizky Ghazi Pamungkas',
                'Mutiara Sekar Lestari',
                'Adrian Farel Setiawan',
                'Shafira Amanda Permata',
                'Naufal Mahesa Kurniawan',
            ],
            15 => [
                'Alya Calista Febriani',
                'Rafiq Abimanyu Pratama',
                'Nadia Nadhira Maharani',
                'Fikri Alvaro Saputra',
                'Tiara Syifa Rahmawati',
                'Rizal Adhi Nugroho',
                'Putri Meisya Anggraini',
                'Daffa Rayhan Firmansyah',
                'Zahra Talita Puspita',
                'Fauzan Rafael Wijaya',
            ],
            16 => [
                'Nadine Aulia Ramadhani',
                'Bima Fathan Prakoso',
                'Aurel Nindya Lestari',
                'Rangga Hafiz Setiawan',
                'Keisya Sekar Maharani',
                'Alif Dito Kurniawan',
                'Vania Najwa Safitri',
                'Rafi Zidan Pamungkas',
                'Citra Humaira Dewi',
                'Kevin Ghani Nugraha',
            ],
        ];

        $nisTerpakai = [];
        $nisnTerpakai = [];
        $siswas = [];

        foreach ($namaSiswaPerKelas as $idKelas => $namaSiswa) {
            foreach ($namaSiswa as $nama) {
                do {
                    $nis = (string) random_int(10000000, 99999999);
                } while (isset($nisTerpakai[$nis]));

                do {
                    $nisn = (string) random_int(1000000000, 9999999999);
                } while (isset($nisnTerpakai[$nisn]));

                $nisTerpakai[$nis] = true;
                $nisnTerpakai[$nisn] = true;
                $siswas[] = [
                    'nis' => $nis,
                    'nisn' => $nisn,
                    'nama' => $nama,
                    'id_kelas' => $idKelas,
                    'status' => 'active',
                ];
            }
        }

        siswaModel::insert($siswas);
    }
}
