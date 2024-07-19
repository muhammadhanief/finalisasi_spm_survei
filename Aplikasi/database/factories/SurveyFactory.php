<?php

namespace Database\Factories;

use App\Models\Survey;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Survey>
 */
class SurveyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Survey::class;

    public function definition(): array
    {
        // Menggunakan Faker untuk membuat nilai untuk 'role_id'

        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'year' => $this->faker->year,
            'expectedRespondents' => $this->faker->randomDigit,
            'role_id' => json_encode([1, 2, 3, 4, 5]),
            'settings' => [],
            'started_at' => $this->faker->dateTime,
            'ended_at' => $this->faker->dateTime,
        ];
    }
}
