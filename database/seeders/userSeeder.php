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
                'username' => 'mikaela',
                'password' => bcrypt('mikaela'),
                'role' => 'admin',
            ],
        ]);
    }
}
