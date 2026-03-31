<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\FuelType;
use App\Models\VehicleMake;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::query()->inRandomOrder()->first(),
            'vehicle_make_id' => $make = VehicleMake::query()->inRandomOrder()->first(),
            'vehicle_model_id' => $make->vehicleModels()->inRandomOrder()->first(),
            'fuel_type_id' => FuelType::query()->inRandomOrder()->first(),
            'number_plate' => fake()->regexify('K[A-Z0-9]{2}\s[0-9]\s[A-Z]'),
            'number_of_gears' => fake()->randomDigitNotNull(),
            'year_of_manufacturing' => fake()->randomNumber(),
            'odometer_reading' => fake()->randomNumber(),
            'gearbox_number' => fake()->regexify('[A-Za-z0-9]{15}'),
            'engine_number' => fake()->regexify('[A-Za-z0-9]{15}'),
            'chassis_number' => fake()->regexify('[A-Za-z0-9]{15}'),
            'description' => fake()->text(),
        ];
    }
}
