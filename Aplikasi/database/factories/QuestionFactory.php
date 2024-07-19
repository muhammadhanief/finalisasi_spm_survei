<?php

namespace Database\Factories;

use App\Models\AnswerOption;
use App\Models\Question;
use App\Models\QuestionType;
use App\Models\Section;
use App\Models\Subdimension;
use App\Models\Survey;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Question::class;

    public function definition()
    {
        return [
            'survey_id' => Survey::factory(),
            'section_id' => Section::factory(),
            'subdimension_id' => Subdimension::factory(),
            'question_type_id' => QuestionType::factory(),
            'answer_option_id' => AnswerOption::factory(),
            'content' => $this->faker->sentence,
        ];
    }
}
