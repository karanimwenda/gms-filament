<?php

namespace Database\Factories;

use App\Models\JobCard;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobCardStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'job_card_id' => JobCard::factory(),
            'status' => fake()->regexify('[A-Za-z0-9]{20}'),
            'changed_by_id' => User::factory(),
            'notes' => fake()->text(),
        ];
    }
}
