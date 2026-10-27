<?php

namespace Database\Seeders;

use App\Models\userModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id_user' => '1',
                'username' => 'admin',
                'password' => 'admin123',
                'role' => 'admin',
            ],
            [
                'id_user' => '2',
                'username' => 'guru',
                'password' => 'guru123',
                'role' => 'guru',
            ],
            [
                'id_user' => '3',
                'username' => 'siswa',
                'password' => 'siswa123',
                'role' => 'siswa',
            ],
        ];

        foreach ($users as $userData) {
            $user = userModel::withTrashed()->updateOrCreate(
                ['id_user' => $userData['id_user']],
                [
                    'username' => $userData['username'],
                    'password' => Hash::make($userData['password']),
                    'role' => $userData['role'],
                    'status' => 'active',
                ],
            );

            if ($user->trashed()) {
                $user->restore();
            }
        }
    }
}
