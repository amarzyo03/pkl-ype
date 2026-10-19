<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\guruModel;

class guruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        guruModel::create([
            'nama' => 'guru1',
            'username' => 'guru1',
            'password' => bcrypt('guru1'),
        ]);
    }
}
