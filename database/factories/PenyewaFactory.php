<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\penyewa>
 */
class PenyewaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(), // Assumes a User model and factory exist
            'Umur' => $this->faker->numberBetween(18, 80), // Random age between 18 and 80
            'Alamat' => $this->faker->address(), // Generates a random full address
            'Jenis Kelamin' => $this->faker->randomElement(['Laki Laki', 'Perempuan']), // Randomly selects from enum options
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // Random timestamp within the last year
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // Random timestamp within the last year
        ];
    }
}