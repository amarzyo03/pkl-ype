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
        dudiModel::factory()
            ->count(100)
            ->sequence(fn ($sequence) => [
                'id' => $sequence->index + 1,
            ])
            ->create();
    }
}
