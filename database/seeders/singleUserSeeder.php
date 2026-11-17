<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\userModel;

class singleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        userModel::create([
            'id_user' => 1,
            'username' => 'mikaela',
            'password' => bcrypt('mikaela'),
            'role' => 'admin',
        ]);
    }
}
