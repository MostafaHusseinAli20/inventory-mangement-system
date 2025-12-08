<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Treasury>
 */
class TreasuryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'is_master' => false,
            'last_recipt_exchange' => fake()->randomFloat(2, 0, 100),
            'last_recipt_collect' => fake()->randomFloat(2, 0, 100),
            'added_by' => 1,
            'com_code' => 1,
            'updated_by' => 1,
            'date' => fake()->date(),
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

