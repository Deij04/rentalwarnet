<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Nama_ruangan' => $this->faker->unique()->words(2, true), // Generates a unique two-word room name
            'Harga_sewa' => $this->faker->randomFloat(2, 100000, 1000000), // Random price between 100,000 and 1,000,000 with 2 decimal places
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // Random timestamp within the last year
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // Random timestamp within the last year
        ];
    }
}