<?php

namespace Database\Seeders;

use App\Models\userModel;
use Illuminate\Database\Seeder;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        userModel::insert([
            [
                'id_user' => 1,
                'username' => 'admin',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ],
            [
                'id_user' => 1,
                'username' => 'guru',
                'password' => bcrypt('guru123'),
                'role' => 'guru',
            ],
            [
                'id_user' => 1,
                'username' => 'siswa',
                'password' => bcrypt('siswa123'),
                'role' => 'siswa',
            ],
        ]);
    }
}
