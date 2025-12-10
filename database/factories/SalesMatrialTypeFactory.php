<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SalesMatrialType>
 */
class SalesMatrialTypeFactory extends Factory
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
            'active' => 1,
            'updated_at' => now(),
            'created_at' => now(),
            'com_code' => 1,
            'added_by' => 1,
            'updated_by' => 1
        ];
    }
}
