<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Option\CreateAnswerOption;
use App\Livewire\Option\SearchAnswerOption;
use App\Models\AnswerOption;
use App\Models\AnswerOptionValue;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Faker\Factory as FakerFactory;

class AnswerOptionTest extends TestCase
{
    // use RefreshDatabase;

    /** @test */
    // opsijawaban create unit
    public function it_creates_answer_option_and_values(): void
    {
        $faker = FakerFactory::create();
        $name = $faker->word;
        $type = $faker->randomElement(['radio', 'checkbox', 'dropdown']);
        $options = [
            $faker->word,
            $faker->word,
            $faker->word,
        ];

        Livewire::test(CreateAnswerOption::class)
            ->set('name', $name)
            ->set('type', $type)
            ->set('options', $options)
            ->call('create');

        $this->assertDatabaseHas('answer_options', [
            'name' => $name,
            'type' => $type,
        ]);

        $answerOption = AnswerOption::where('name', $name)->first();

        foreach ($options as $key => $option) {
            $this->assertDatabaseHas('answer_option_values', [
                'name' => $option,
                'answer_option_id' => $answerOption->id,
                'value' => $key + 1,
            ]);
        }
    }

    // opsijawbaan delete integration
    public function it_deletes_answer_option_and_values_when_not_used_in_questions(): void
    {
        // Create an answer option without related questions
        $answerOption = AnswerOption::factory()->create();
        $answerOptionValues = AnswerOptionValue::factory(3)->create(['answer_option_id' => $answerOption->id]);

        // Test deleting the answer option
        Livewire::test(SearchAnswerOption::class)
            ->call('delete', $answerOption->id);

        // Assert that the answer option and its values were deleted from the database
        $this->assertDatabaseMissing('answer_options', [
            'id' => $answerOption->id,
        ]);

        foreach ($answerOptionValues as $value) {
            $this->assertDatabaseMissing('answer_option_values', [
                'id' => $value->id,
            ]);
        }
    }

    /** @test */
    // opsijawbaan delete integration
    public function it_does_not_delete_answer_option_when_used_in_questions(): void
    {
        // Create an answer option used in questions
        $answerOption = AnswerOption::factory()->create();
        $question = Question::factory()->create(['answer_option_id' => $answerOption->id]);

        // Test trying to delete the answer option
        Livewire::test(SearchAnswerOption::class)
            ->call('delete', $answerOption->id);

        // Assert that the answer option still exists in the database
        $this->assertDatabaseHas('answer_options', [
            'id' => $answerOption->id,
        ]);
    }
}
