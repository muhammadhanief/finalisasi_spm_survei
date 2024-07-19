<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Answer::class;

    public function definition(): array
    {
        return [
            'question_id' => \App\Models\Question::factory(),
            'entry_id' => \App\Models\Entry::factory(),
            'question_type_id' => \App\Models\QuestionType::factory(),
            'value' => $this->faker->word,
        ];
    }
}
