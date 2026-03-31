<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\JobCard;
use App\Models\Part;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobCardItemFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'job_card_id' => JobCard::factory(),
            'type' => fake()->regexify('[A-Za-z0-9]{20}'),
            'service_id' => Service::factory(),
            'part_id' => Part::factory(),
            'employee_id' => Employee::factory(),
            'buying_price' => fake()->randomFloat(2, 0, 999999.99),
            'selling_price' => fake()->randomFloat(2, 0, 999999.99),
            'quantity' => fake()->randomNumber(),
            'sub_total' => fake()->randomFloat(2, 0, 999999.99),
        ];
    }
}
