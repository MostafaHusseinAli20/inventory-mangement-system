<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvItemCard>
 */
class InvItemCardFactory extends Factory
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
            'barcode' => fake()->ean13(),
            'item_code' => fake()->unique()->numberBetween(1000, 9999),
            'item_type' => 1,
            'inv_item_card_category_id' => 1,
            'inv_uom_id' => 1,
            'retail_uom_quntToParent' => 1,
            'added_by' => 1,
            'com_code' => 1,
            'updated_by' => 1,
            'price_uom' => 200,
            'half_gomla_price_uom' => 200,
            'gomla_price_uom' => 200,
            'cost_price' => 200,
        ];
    }
}
