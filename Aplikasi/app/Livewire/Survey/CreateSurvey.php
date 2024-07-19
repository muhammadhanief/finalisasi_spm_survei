<?php

namespace App\Livewire\Survey;

use App\Models\Survey;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Validate;
use App\Models\Dimension;
use App\Models\Question;
use App\Models\Section;
use App\Models\Subdimension;
use App\Models\Entry;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\AnswerOption;
use App\Models\AnswerOptionValue;
use Livewire\Attributes\On;

class CreateSurvey extends Component
{
    use LivewireAlert;
    #[Validate(['required', 'min:5'])]
    public $name = '';
    #[Validate(['required', 'min:5'])]
    public $description = '';
    #[Validate('required|not_in:')]
    public $DimensionType = '';
    #[Validate(['required', 'numeric', 'digits:4'])]
    public $year = '';
    #[Validate(['required', 'numeric'])]
    public $expectedRespondents = '';
    // #[Validate(['required', 'numeric', 'gt:0'])]
    // public $limitPerParticipant = '';
    #[Validate(['required'], ['array'])]
    public $roleIdParticipant = [];
    #[Validate(['required'])]
    public $startAt = '';
    #[Validate(['required', 'after:startAt'])]
    public $endAt = '';


    // ...refreshPaths,

    // Temporary variables for section and question
    #[Validate('required|min:3')]
    public $newSectionName = '';
    #[Validate('required|not_in:')]
    public $sectionQuestionType = '';
    #[Validate('required|not_in:')]
    public $sectionAnswerOption = '';
    #[Validate('required|not_in:')]
    public $sectionSubDimensionType = '';

    // #[Validate('required|not_in:')]
    // public $rootDimension;

    public $sections = [];
    public $currentSection = 0;

    public $showAddSectionForm = false;

    public $surveyID;

    public $isEditing = false;

    public function rules()
    {
        $arraySection = [];
        foreach ($this->sections as $key => $section) {
            foreach ($section as $key2 => $question) {
                if (is_numeric($key2)) {
                    $arraySection['sections.' . $key . '.' . $key2 . '.questionName'] = 'required';
                    $arraySection['sections.' . $key . '.' . $key2 . '.sectionID'] = 'required';
                    $arraySection['sections.' . $key . '.' . $key2 . '.dimensionID'] = 'required';
                }
            }
        }
        // dd($arraySection);

        $cobaRule = [
            'name' => [
                'required',
                'min:5',
            ],
            'description' => [
                'required',
                'min:5',
            ],
            'year' => [
                'required',
                'numeric', 'digits:4',
            ],
            'expectedRespondents' => [
                'required',
                'numeric',
            ],
            // 'limitPerParticipant' => [
            //     'required',
            //     'numeric',
            //     'gt:0'
            // ],
            'roleIdParticipant' => [
                'required',
                'numeric',
                'min:1',
                'not_in:'
            ],
            'startAt' => [
                'required',
            ],
            'endAt' => [
                'required',
                'after:startAt'
            ],
        ];
        return $cobaRule;
        // dd($cobaRule, $arraySection, $mergedArray);
    }

    public function addSection()
    {
        $addSectionRule = [
            'newSectionName' => [
                'required', 'min:3',
            ],
            'sectionQuestionType' => [
                'required', 'not_in:',

            ],
            'sectionSubDimensionType' => [
                'required', 'not_in:',
            ],
        ];
        if ($this->sectionQuestionType == 'harapanDanKenyataan') {
            $addSectionRule['sectionAnswerOption'] = [
                'required', 'not_in:',
            ];
        }
        $this->validate($addSectionRule);
        $section = [
            'name' => $this->newSectionName,
            'sectionQuestionType' => $this->sectionQuestionType,
            'sectionSubDimensionType' => $this->sectionSubDimensionType,
            'sectionAnswerOption' => $this->sectionAnswerOption,
        ]; // Buat objek model Section
        $this->sections[] = $section;
        $this->currentSection = count($this->sections) - 1;
        // $this->newSectionName = ''; // Reset nama bagian setelah menambahkan
        $this->showAddSectionForm = false; // Sembunyikan form setelah menambahkan bagian baru
        $this->reset('sectionQuestionType', 'newSectionName',  'sectionAnswerOption', 'sectionSubDimensionType');
        session()->flash('successAddSection', 'Blok sukses ditambahkan.');
    }

    public function cancelSection()
    {
        // $this->newSectionName = ''; // Reset nama bagian setelah menambahkan
        $this->reset('newSectionName');
        $this->showAddSectionForm = false; // Sembunyikan form setelah menambahkan bagian baru
    }

    public function deleteSection($index)
    {
        $this->currentSection = 0;
        array_splice($this->sections, $index, 1);
    }

    public function addQuestion($key)
    {
        $this->sections[$key][] = [
            'questionName' => '',
            'sectionID' => $key,
        ];
        // $this->questions[$key][] = $newQuestion;
    }

    public function deleteQuestion($sectionIndex, $questionIndex)
    {
        unset($this->sections[$sectionIndex][$questionIndex]);
        // Mengurutkan ulang indeks kunci
        $this->sections[$sectionIndex] = array_merge($this->sections[$sectionIndex]);
        // $this->sections[$sectionIndex] = array_values($this->sections[$sectionIndex]);
    }

    public function validateSurvey()
    {
        $surveyArrayRule = [
            'name' => [
                'required',
                'min:5',
            ],
            'description' => [
                'required',
                'min:5',
            ],
            'DimensionType' => [
                'required',
                'not_in:'
            ],
            'year' => [
                'required',
                'numeric', 'digits:4',
            ],
            'expectedRespondents' => [
                'required',
                'numeric',
            ],
            'roleIdParticipant' => [
                'required',
            ],
            // 'limitPerParticipant' => [
            //     'required',
            //     'numeric',
            //     'gt:0'
            // ],
            'startAt' => [
                'required',
            ],
            'endAt' => [
                'required',
                'after:startAt'
            ],

        ];
        $this->validate($surveyArrayRule);
    }

    public function createSurvey()
    {
        $this->validateSurvey();
        $survey = Survey::create([
            'name' => $this->name,
            'description' => $this->description,
            'year' => $this->year,
            'expectedRespondents' => $this->expectedRespondents,
            'role_id' => json_encode(array_keys($this->roleIdParticipant)),
            // 'settings' => ['limit-per-participant' => $this->limitPerParticipant],
            'started_at' => $this->startAt,
            'ended_at' => $this->endAt,
        ]);
        $this->surveyID = $survey->id;
    }

    public function addAnswerOptionIDToHarapanDanKenyataan()
    {
        foreach ($this->sections as $key => $section) {
            if ($section['sectionQuestionType'] == 'harapanDanKenyataan') {
                foreach ($section as $key2 => $question) {
                    if (is_numeric($key2)) {
                        $this->sections[$key][$key2]['answerOptionID'] = $section['sectionAnswerOption'];
                        if (!isset($this->sections[$key][$key2]['dimensionID'])) {
                            $this->sections[$key][$key2]['dimensionID'] = $section['sectionSubDimensionType'];
                        }
                    }
                }
            } else {
                foreach ($section as $key2 => $question) {
                    if (is_numeric($key2)) {
                        // if (!isset($this->sections[$key][$key2]['answerOptionID'])) {
                        if (!isset($this->sections[$key][$key2]['dimensionID'])) {
                            $this->sections[$key][$key2]['dimensionID'] = $section['sectionSubDimensionType'];
                        }
                    }
                }
            }
        }
    }

    public function validateSectionAndQuestion()
    {
        $this->addAnswerOptionIDToHarapanDanKenyataan();

        $secQuesArrayRule = [];
        $messages = [];
        $attributes = [];

        foreach ($this->sections as $key => $section) {
            foreach ($section as $key2 => $question) {
                if (is_numeric($key2)) {
                    $secQuesArrayRule['sections.' . $key . '.' . $key2 . '.questionName'] = 'required';
                    $secQuesArrayRule['sections.' . $key . '.' . $key2 . '.sectionID'] = 'required';
                    $secQuesArrayRule['sections.' . $key . '.' . $key2 . '.dimensionID'] = 'required';
                    $secQuesArrayRule['sections.' . $key . '.' . $key2 . '.answerOptionID'] = 'required';

                    // Menambahkan pesan kesalahan
                    $messages['required'] = ':Attribute wajib diisi.';
                    $messages["sections.{$key}.{$key2}.questionName.required"] = "Pertanyaan wajib diisi.";

                    // Menambahkan atribut
                    $attributes["sections.{$key}.{$key2}.questionName"] = "Pertanyaan";
                    $attributes["sections.{$key}.{$key2}.sectionID"] = "ID Bagian ke-{$key}";
                    $attributes["sections.{$key}.{$key2}.dimensionID"] = "Subdimensi";
                }
            }
        }

        // Cek apakah $secQuesArrayRule kosong
        if (empty($secQuesArrayRule)) {
            // Aturan validasi kosong, maka tampilkan pesan kesalahan
            return false;
        } else {
            // Validasi dengan aturan yang telah dibuat
            $this->validate($secQuesArrayRule, $messages, $attributes);
            return true;
        }
    }

    public function createSectionAndQuestion()
    {
        // Validasi dan simpan Section
        // dd($this->sections);
        foreach ($this->sections as $key => $section) {
            // dd($this->sections, $section['name']);
            $createdSection = Section::create([
                'name' => $section['name'],
                'survey_id' => $this->surveyID,
            ]);
            $createdSectionID = $createdSection->id;
            // Validasi dan simpan Question
            foreach ($section as $key2 => $question) {
                if (is_numeric($key2)) {
                    // if else for different question type based on sectionQuestionType
                    if ($this->sections[$key]['sectionQuestionType'] == 'tunggal') {
                        Question::create([
                            'survey_id' => $this->surveyID,
                            'section_id' => $createdSectionID,
                            'subdimension_id' => $question['dimensionID'],
                            'question_type_id' => '1',
                            'content' => $question['questionName'],
                            'type' => 'udin',
                            'answer_option_id' => $question['answerOptionID'],
                        ]);
                    } elseif ($this->sections[$key]['sectionQuestionType'] == 'harapanDanKenyataan') {
                        Question::create([
                            'survey_id' => $this->surveyID,
                            'section_id' => $createdSectionID,
                            'subdimension_id' => $question['dimensionID'],
                            'question_type_id' => '2',
                            'content' => $question['questionName'],
                            'type' => 'udin',
                            'answer_option_id' => $question['answerOptionID'],
                        ]);
                        Question::create([
                            'survey_id' => $this->surveyID,
                            'section_id' => $createdSectionID,
                            'subdimension_id' => $question['dimensionID'],
                            'question_type_id' => '3',
                            'content' => $question['questionName'],
                            'type' => 'udin',
                            'answer_option_id' => $question['answerOptionID'],
                        ]);
                    }
                }
            }
        }
    }

    public function create()
    {
        $this->validateSurvey();

        if ($this->validateSectionAndQuestion()) {
            // dd('ga masuk sini');
            $this->createSurvey();
            $this->createSectionAndQuestion();
            $this->reset();
            $this->alert('success', 'Sukses!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => true,
                'text' => 'Survei sukses ditambahkan.',
            ]);
        } else {
            $this->alert('error', 'Gagal!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => true,
                'text' => 'Survei gagal ditambahkan karena question gada samsek. buat question lalu submit ulang',
            ]);
            // session()->flash('failedAdd', 'Survey gagal ditambahkan karena question gada samsek. buat question lalu submit ulang');
        }
    }

    public function dd()
    {
        dd($this->all());
    }

    public function mount($oldSurveyID = null)
    {
        if ($oldSurveyID) {
            $this->isEditing = true;
            $oldSurvey = Survey::find($oldSurveyID);
            $this->name = $oldSurvey->name;
            $this->description = $oldSurvey->description;
            $this->year = $oldSurvey->year;
            $this->expectedRespondents = $oldSurvey->expectedRespondents;
            // $this->limitPerParticipant = $oldSurvey->settings['limit-per-participant'];
            // untuk dimensi di awal
            $oldSectiionFirst = Section::where('survey_id', $oldSurveyID)->first();
            $oldSubdimensionFirst = $oldSectiionFirst->questions[0]->subdimension;
            $oldDimension = $oldSubdimensionFirst->dimension()->first()->id;
            $this->DimensionType = $oldDimension;

            $roleIds = json_decode($oldSurvey->role_id, true);
            $this->roleIdParticipant = array_combine($roleIds, array_fill(0, count($roleIds), true));
            $this->startAt = $oldSurvey->started_at;
            $this->endAt = $oldSurvey->ended_at;
            $this->surveyID = $oldSurveyID;

            $oldSections = Section::where('survey_id', $oldSurveyID)->get();
            foreach ($oldSections as $key => $oldSection) {
                $oldQuestions = Question::where('section_id', $oldSection->id)->get();
                // dd($oldQuestions[0]->subdimension->dimension->id);
                $section = [
                    'name' => $oldSection->name,
                    'sectionQuestionType' => $oldQuestions[0]->questionType->name,
                    // 'DimensionType' => $oldQuestions[0]->subdimension->dimension->id,
                    'sectionAnswerOption' => $oldQuestions[0]->answerOption->id,
                ];
                $this->sections[] = $section;
                foreach ($oldQuestions as $oldQuestion) {
                    if ($oldQuestion->questionType->name == 'Kenyataan') {
                    } else {
                        $this->sections[count($this->sections) - 1][] = [
                            'questionName' => $oldQuestion->content,
                            'sectionID' => $key,
                            'dimensionID' => $oldQuestion->subdimension_id,
                            'answerOptionID' => $oldQuestion->answer_option_id,
                        ];
                        if ($oldQuestion->questionType->name == 'Harapan') {
                            $this->sections[count($this->sections) - 1]['sectionQuestionType'] = 'harapanDanKenyataan';
                        } elseif ($oldQuestion->questionType->name == 'Umum') {
                            $this->sections[count($this->sections) - 1]['sectionQuestionType'] = 'tunggal';
                        }
                    }
                }
            }
            // dd($this->sections);
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $roles = Role::whereNotIn('name', ['SuperAdmin', 'Admin', 'User'])->get();
        return view('livewire.survey.create-survey', [
            'roles' => $roles,
            'dimensions' => Dimension::all(),
            'subdimensions' => Subdimension::all(),
            'answerOptions' => AnswerOption::all(),
            'answerOptionValues' => AnswerOptionValue::all(),
        ]);
    }
}
