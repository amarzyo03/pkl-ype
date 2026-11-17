<?php

namespace Database\Factories;

use App\Models\dudiModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<dudiModel>
 */
class dudiModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('id_ID');

        return [
            'nama' => $faker->company(),
            'alamat' => $faker->address(),
            'telp' => $faker->phoneNumber(),
            'pic' => $faker->name(),
            'id_jurusan' => $faker->numberBetween(1, 5),
            'id_guru' => $faker->numberBetween(2, 55),
        ];
    }
}
