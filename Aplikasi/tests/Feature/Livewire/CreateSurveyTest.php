<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Survey\CreateSurvey;
use App\Models\Dimension;
use Faker\Factory as Faker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateSurveyTest extends TestCase
{
    /** @test */
    public function it_validates_survey_successfully()
    {
        $dimensionType = Dimension::all()->random()->id;
        Livewire::test(CreateSurvey::class)
            ->set('name', 'Valid Survey Name')
            ->set('description', 'Valid description for the survey')
            ->set('DimensionType', $dimensionType) // Assuming '1' is a valid DimensionType
            ->set('year', 2023)
            ->set('expectedRespondents', 100)
            ->set('roleIdParticipant', [1, 2]) // Assuming these are valid role IDs
            ->set('startAt', '2024-05-20T11:35')
            ->set('endAt', '2024-06-01T11:35')
            ->call('validateSurvey')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_validates_sections_and_questions_successfully()
    {
        $sections = [
            [
                'name' => 'Section 1',
                'sectionQuestionType' => 'tunggal',
                'sectionSubDimensionType' => 1,
                'sectionAnswerOption' => '',
                [
                    'questionName' => 'Question 1',
                    'sectionID' => 1,
                    'dimensionID' => 1,
                    'answerOptionID' => 1,
                ],
                [
                    'questionName' => 'Question 2',
                    'sectionID' => 1,
                    'dimensionID' => 1,
                    'answerOptionID' => 2,
                ],
            ],
            [
                'name' => 'Section 2',
                'sectionQuestionType' => 'harapanDanKenyataan',
                'sectionSubDimensionType' => 2,
                'sectionAnswerOption' => 3,
                [
                    'questionName' => 'Question 3',
                    'sectionID' => 2,
                    'dimensionID' => 2,
                    'answerOptionID' => 3,
                ],
                [
                    'questionName' => 'Question 4',
                    'sectionID' => 2,
                    'dimensionID' => 2,
                    'answerOptionID' => 4,
                ],
            ],
        ];

        Livewire::test(CreateSurvey::class)
            ->set('sections', $sections)
            ->call('validateSectionAndQuestion')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_creates_a_survey_successfully()
    {
        $data = [
            'name' => 'Survey Test',
            'description' => 'Deskripsi survei test',
            'DimensionType' => 1,
            'year' => 2024,
            'expectedRespondents' => 100,
            'roleIdParticipant' => [1 => 'Admin', 2 => 'User'],
            'startAt' => '2024-05-20T11:35',
            'endAt' => '2024-06-01T11:35',
        ];

        Livewire::test(CreateSurvey::class)
            ->set('name', $data['name'])
            ->set('description', $data['description'])
            ->set('DimensionType', $data['DimensionType'])
            ->set('year', $data['year'])
            ->set('expectedRespondents', $data['expectedRespondents'])
            ->set('roleIdParticipant', $data['roleIdParticipant'])
            ->set('startAt', $data['startAt'])
            ->set('endAt', $data['endAt'])
            ->call('createSurvey')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('surveys', [
            'name' => $data['name'],
            'description' => $data['description'],
            'year' => $data['year'],
            'expectedRespondents' => $data['expectedRespondents'],
            'role_id' => json_encode(array_keys($data['roleIdParticipant'])),
            'started_at' => $data['startAt'],
            'ended_at' => $data['endAt'],
        ]);
    }
}
