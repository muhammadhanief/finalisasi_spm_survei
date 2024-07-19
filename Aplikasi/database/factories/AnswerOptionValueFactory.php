<?php

namespace Database\Factories;

use App\Models\AnswerOption;
use App\Models\AnswerOptionValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnswerOptionValue>
 */
class AnswerOptionValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = AnswerOptionValue::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'answer_option_id' => AnswerOption::factory(),
            'value' => $this->faker->randomDigitNotNull,
        ];
    }
}
