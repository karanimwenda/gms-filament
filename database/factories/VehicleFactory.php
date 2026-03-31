<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\FuelType;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'vehicle_make_id' => VehicleMake::factory(),
            'vehicle_model_id' => VehicleModel::factory(),
            'fuel_type_id' => FuelType::factory(),
            'number_plate' => fake()->regexify('[A-Za-z0-9]{20}'),
            'number_of_gears' => fake()->randomDigitNotNull(),
            'year_of_manufacturing' => fake()->randomNumber(),
            'odometer_reading' => fake()->randomNumber(),
            'gearbox_number' => fake()->regexify('[A-Za-z0-9]{50}'),
            'engine_number' => fake()->regexify('[A-Za-z0-9]{50}'),
            'chassis_number' => fake()->regexify('[A-Za-z0-9]{50}'),
            'description' => fake()->text(),
        ];
    }
}
