<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

use Database\Factories\CandidateFactory;

use App\Models\Candidate;

class CandidatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Candidate::create([
        //     'id' => Str::uuid(),
        //     'owner_id' => '2b63a0b8-00a0-446c-a9a5-6c54b059f2e1',
        //     'first_name' => 'John',
        //     'last_name' => 'Doe',
        //     'age' => 30,
        //     'department' => 'IT',
        //     'min_salary_expectation' => '10000',
        //     'max_salary_expectation' => '20000',
        //     'currency_id' => 'f12607d6-5cae-472f-89d5-be470e6a24f2',
        //     'address_id' => '0be26bef-4589-4b02-a031-85b2189c402b'
        // ]);

        Candidate::factory()->count(10)->create();
    }
}
