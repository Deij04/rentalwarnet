<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaksi>
 */
class TransaksiFactory extends Factory
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
            'penyewa_id' => \App\Models\Penyewa::factory(), // Assumes a Penyewa model and factory exist
            'room_id' => \App\Models\Room::factory(), // Assumes a Room model and factory exist
            'date' => $this->faker->dateTimeBetween('-6 months', 'now'), // Random date/time within the last 6 months
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // Random timestamp within the last year
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // Random timestamp within the last year
        ];
    }
}