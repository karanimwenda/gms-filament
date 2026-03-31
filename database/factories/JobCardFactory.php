<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobCardFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'vehicle_id' => Vehicle::factory(),
            'total' => fake()->randomFloat(2, 0, 999999999999.99),
            'status' => fake()->regexify('[A-Za-z0-9]{20}'),
            'notes' => fake()->text(),
        ];
    }
}
