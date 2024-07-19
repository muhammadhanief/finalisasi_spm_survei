<?php

namespace App\Livewire\Survey;

use Livewire\Attributes\Layout;
use App\Models\Survey;
use Livewire\Component;
use App\Models\Question;
use App\Models\Answer;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\TargetResponden;
use App\Models\Entry;

class FillSurveyDetail extends Component
{
    use LivewireAlert;
    public $surveyID;
    public $uniqueCode;
    public $entryID;
    public $isKuota = false;
    public $answers = [];
    public $tester = [];
    public $uuid;


    // Fungsi mount digunakan untuk menginisialisasi komponen dengan parameter rute.
    public function mount($uuid, $uniqueCode = null)
    {
        $this->uuid = $uuid;
        $this->surveyID = Survey::where('uuid', $uuid)->first()->id;
        $this->uniqueCode = $uniqueCode;
        $questions = Question::where('survey_id', $this->surveyID)->get();
        foreach ($questions as $question) {
            $this->answers[$question->id] = [
                'question_id' => $question->id,
                'value' => [],
                'question_type_id' => '',
            ];
        }

        $targetResponden = TargetResponden::where('unique_code', $uniqueCode)->first();
        // dd($targetResponden);
        if ($targetResponden != null) {
            $targetRespondenID = $targetResponden->id;
            if ($targetResponden->type == 'group') {
                $this->isKuota = true;
            } else {
                $entry = Entry::where('survey_id', $this->surveyID)->where('target_responden_id', $targetRespondenID)->first();
                if ($entry == null) {
                    $this->isKuota = true;
                }
            }
        } else {
            $this->isKuota = true;
        }

        // dd($this->isKuota);
    }

    public function setQuestionTypeID()
    {
        foreach ($this->answers as $key => $answer) {
            $questionModel = Question::find($key);
            $this->answers[$key]['question_id'] = $key;
            $this->answers[$key]['question_type_id'] = $questionModel->questionType->id;
        }
    }

    public function validateAnswer()
    {
        $answerArrayRule = [
            'answers' => 'required|array',
            'answers.*.value' => 'required',
        ];
        $messages = [
            'required' => 'Pertanyaan wajib diisi.',
            'answers.required' => 'The :attribute are missing.',
        ];
        $attributes = [
            'answers.*.value' => 'answer',
        ];

        // Cek apakah $secQuesArrayRule kosong
        if (empty($answerArrayRule)) {
            // Aturan validasi kosong, maka tampilkan pesan kesalahan
            return false;
        } else {
            // Validasi dengan aturan yang telah dibuat
            $this->validate($answerArrayRule, $messages, $attributes);
            return true;
        }
    }

    public function save()
    {
        // dd('dia udah masuk sini');
        foreach ($this->answers as $key => $answer) {
            if (is_array($answer['value'])) {
                $arrayValue = array_keys($answer['value']);
                $answer['value'] = json_encode($arrayValue);
            }
            Answer::create([
                'question_id' => $answer['question_id'],
                'value' => $answer['value'],
                'question_type_id' => $answer['question_type_id'],
                'entry_id' => $this->entryID,
            ]);
        }
    }

    public function addEntry()
    {
        $targetResponden = TargetResponden::where('unique_code', $this->uniqueCode)->first();
        $targetRespondenID = $targetResponden ? $targetResponden->id : null;
        // dd($targetRespondenRoleID);
        $entry = Entry::create([
            'survey_id' => $this->surveyID,
            'target_responden_id' => $targetRespondenID,
        ]);
        $this->entryID = $entry->id;
    }

    public function create()
    {
        $this->setQuestionTypeID();
        if ($this->validateAnswer()) {
            $this->addEntry();
            $this->save();
            $tempSurveyID = $this->surveyID;
            $tempAnswers = $this->answers;
            $tempUniqueCode = $this->uniqueCode;
            $this->reset();
            $this->surveyID = $tempSurveyID;
            $this->uniqueCode = $tempUniqueCode;
            // $this->mount($this->surveyID, $this->uniqueCode);
            // $this->alert('success', 'Sukses!', [
            //     'position' => 'center',
            //     'timer' => 2000,
            //     'toast' => true,
            //     'text' => 'Jawaban sukses dikumpulkan.',
            // ]);
            // dd('op');
            session()->flash('status', [
                'title' => 'Perubahan peringkat',
                'text' => 'Perubahan peringkat',
                'rankBeforeEdited' => 'Perubahan peringkat',
                'rankAfterEdited' => 'Perubahan peringkat',
            ]);
            return redirect()->route('survey.visualize');
        } else {
            $this->alert('error', 'Gagal!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => true,
                'text' => 'Jawaban gagal dikumpulkan.',
            ]);
        }
    }

    // untuk section yang dipisah
    public $currentSectionIndex = -1;
    public $survey;

    public function nextSection()
    {
        if ($this->currentSectionIndex != -1) {
            $validationRules = [];
            $messages = [];
            // // Tambahkan aturan validasi untuk setiap pertanyaan pada bagian saat ini
            foreach ($this->survey->sections[$this->currentSectionIndex]->questions as $question) {
                $validationRules['answers.' . $question->id . '.value'] = 'required';
                $messages['answers.' . $question->id . '.value.required'] = 'Pertanyaan wajib diisi.';
            }
            $this->validate($validationRules, $messages);
        }
        // Pindah ke bagian berikutnya jika validasi berhasil
        if ($this->currentSectionIndex < count($this->survey->sections) - 1) {
            $this->currentSectionIndex++;
        }
    }

    public function previousSection()
    {
        if ($this->currentSectionIndex > -1) {
            $this->currentSectionIndex--;
        }
    }

    public function dd()
    {
        dd($this->all());
    }



    #[Layout('layouts.app')]
    public function render()
    {
        // mengambil data survey
        $surveyID = $this->surveyID;
        $survey = Survey::find($surveyID);
        $this->survey = $survey;
        if ($survey == null) {
            return view('errors.404');
        }
        $arrayOfRoleSurvey = json_decode($survey->role_id);

        // mengambil data target responden
        $targetResponden = TargetResponden::where('unique_code', $this->uniqueCode)->first();
        if ($targetResponden == null) {
            // return view('errors.404');
            $targetRespondenRoleID = null;
        } else {
            $targetRespondenRoleID = $targetResponden->role_id;
        }

        $isMatched = false;
        foreach ($arrayOfRoleSurvey as $role_id) {
            if ($role_id == $targetRespondenRoleID) {
                $isMatched = true;
                break;
            }
        }

        // if ($survey != null && $isMatched && $this->isKuota) {
        // gajadi make ismatched karena tidak jadi pake unique code
        if ($survey != null) {
            // Redirect or provide a proper response for non-existing surveyID
            return view('livewire.survey.fill-survey-detail', [
                'survey' => $survey,
                'targetResponden' => $targetResponden,
            ]);
        }
        // elseif ($this->isKuota == false) {
        //     return view('errors.404-limit');
        // } 
        else {
            return view('errors.404');
        }
    }
}
