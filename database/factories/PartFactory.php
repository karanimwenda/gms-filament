<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PartFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'buying_price' => fake()->randomFloat(2, 0, 999999.99),
            'selling_price' => fake()->randomFloat(2, 0, 999999.99),
            'quantity_in_stock' => fake()->randomNumber(),
        ];
    }
}
