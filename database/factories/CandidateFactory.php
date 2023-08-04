<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Str;

use App\Models\Candidate;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidate>
 */
class CandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'owner_id' => '2b63a0b8-00a0-446c-a9a5-6c54b059f2e1',
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'age' => $this->faker->numberBetween(18, 60),
            'department' => $this->faker->word,
            'min_salary_expectation' => $this->faker->numberBetween(10000, 100000),
            'max_salary_expectation' => $this->faker->numberBetween(10000, 100000),
            'currency_id' => 'f12607d6-5cae-472f-89d5-be470e6a24f2',
            'address_id' => '0be26bef-4589-4b02-a031-85b2189c402b'
        ];
    }
}
