<?php

namespace Database\Seeders;

use App\Models\jurusanModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class jurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        jurusanModel::insert([
            'kode'          => 'tkj',
            'nama'          => 'teknik komputer dan jaringan',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
    }
}
