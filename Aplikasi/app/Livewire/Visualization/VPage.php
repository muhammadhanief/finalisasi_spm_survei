<?php

namespace App\Livewire\Visualization;

use App\Models\Answer;
use App\Models\Dimension;
use App\Models\Question;
use App\Models\Survey;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Subdimension;
use App\Models\Entry;
use Livewire\Attributes\Validate;

class VPage extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $lastUpdatedTime;
    #[Validate('required|not_in:')]
    public $surveyID;
    public $dataGap = [];
    public $dataDeskripsi = [];


    // untuk pie chart1 
    #ini mau nyimpan id saja
    public $dimensionofSurvei;
    #ini baru model
    public $modelDimensionofSurvei;
    #[Validate('required|not_in:')]
    public $subDimension;
    public $dataChartPieDimension = [];
    public $judulsubDimension;
    public $dateUpdatedSurveyData = null;

    public $uuid;


    public function updatedsurveyID()
    {
        $this->dateUpdatedSurveyData = null;
        $this->getdataChartFromDatabase();
        // $this->updatedsurveyIDLive();
        $this->modelDimensionofSurvei = Dimension::find($this->dimensionofSurvei);
        $this->dateUpdatedSurveyData = Survey::find($this->surveyID)->updated_at;
        // dd($this->dateUpdatedSurveyData);
    }

    // yang livew
    public function perbaruisurveyIDLive()
    {
        $this->dateUpdatedSurveyData = null;
        $this->generateChart();
        $this->modelDimensionofSurvei = Dimension::find($this->dimensionofSurvei);
        $this->dateUpdatedSurveyData = now();
    }

    // yang dari database   
    public function getDataChartFromDatabase()
    {
        $rules = [
            'surveyID' => 'required|not_in:',
        ];
        $messages = [
            'required' => ':attribute wajib diisi.',
            'min' => ':attribute minimal wajib :min karakter.',
            'not_in' => ':attribute wajib memiliki nilai yang valid.',
        ];
        $attributes = [
            'surveyID' => 'Survei',
        ];
        $this->validate($rules, $messages, $attributes);

        $survey = Survey::find($this->surveyID);
        $data_gap = $survey->data_gap;
        $data_gap_array = json_decode($data_gap, true);
        // dd($data_gap_array);
        // $this->dataGap = $data_gap_array;
        $this->dataDeskripsi = $data_gap_array['dataDeskripsi'];
        $this->dimensionofSurvei = $data_gap_array['dimensionofSurvei'];
        $this->dispatch('chartUpdated', $data_gap_array);
        // dd($data_gap);
    }



    public function updatedsubDimension()
    {
        $this->generatePieChartDimension();
    }

    public function getDataChart()
    {
        ini_set('memory_limit', '1G');
        set_time_limit(60);
        $questionHarapan = Question::where('survey_id', $this->surveyID)->where('question_type_id', 2)->get();
        $answersHarapan = Answer::whereIn('question_id', $questionHarapan->pluck('id'))->get();

        $answersHarapan = $answersHarapan->map(function ($answer) use ($questionHarapan) {
            $subdimensionId = $questionHarapan->where('id', $answer->question_id)->pluck('subdimension_id')->first();
            $answer->subdimension_id = $subdimensionId;
            return $answer;
        });

        $rekapitulasiHarapan = $answersHarapan->groupBy('subdimension_id')->map(function ($answers) {
            $totalValue = $answers->sum('value');
            $averageValue = $totalValue / $answers->count();
            return round($averageValue, 2);
        })->values()->toArray();

        $labels = Subdimension::whereIn('id', $questionHarapan->pluck('subdimension_id'))->orderBy('id')->pluck('name')->toArray();

        $questionKenyataan = Question::where('survey_id', $this->surveyID)->where('question_type_id', 3)->get();
        $answersKenyataan = Answer::whereIn('question_id', $questionKenyataan->pluck('id'))->get();
        $answersKenyataan = $answersKenyataan->map(function ($answer) use ($questionKenyataan) {
            $subdimensionId = $questionKenyataan->where('id', $answer->question_id)->pluck('subdimension_id')->first();
            $answer->subdimension_id = $subdimensionId;
            return $answer;
        });
        $rekapitulasiKenyataan = $answersKenyataan->groupBy('subdimension_id')->map(function ($answers) {
            $totalValue = $answers->sum('value');
            $averageValue = $totalValue / $answers->count();
            return round($averageValue, 2);
        })->values()->toArray();

        $this->dataGap['radar'] = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Harapan',
                    'data' => $rekapitulasiHarapan,
                ],
                [
                    'label' => 'Kenyataan',
                    'data' => $rekapitulasiKenyataan,
                ],
            ],
        ];



        $noDimensiRekapitulasiKenyataan = round($answersKenyataan->avg('value'), 2);
        $noDimensiRekapitulasiHarapan = round($answersHarapan->avg('value'), 2);
        $gapTemp = round($noDimensiRekapitulasiKenyataan - $noDimensiRekapitulasiHarapan, 2);
        if ($gapTemp < 0) {
            $gapKenyataan = $gapTemp * -1;
            $gapHarapan = 0;
        } else {
            $gapKenyataan = 0;
            $gapHarapan = $gapTemp;
        }

        $this->dataGap['stackedBarGap'] = [
            $nilai = [$noDimensiRekapitulasiHarapan, $noDimensiRekapitulasiKenyataan,],
            $gap = [$gapHarapan, $gapKenyataan,],
        ];

        $gapPerDimensi = [];

        foreach ($this->dataGap['radar']['labels'] as $key => $label) {
            $gap = abs($this->dataGap['radar']['datasets'][1]['data'][$key] - $this->dataGap['radar']['datasets'][0]['data'][$key]);
            $gapPerDimensi[$label] = $gap;
        }

        // for quadrant
        $newData = [];

        foreach ($labels as $key => $label) {
            $newData[] = [
                'label' => $label,
                'data' => [
                    [
                        'x' => $rekapitulasiHarapan[$key],
                        'y' => $rekapitulasiKenyataan[$key],
                    ],
                ],
            ];
        }

        $this->dataGap['quadrants']['data'] = [
            'datasets' => $newData,
        ];
        $this->dataGap['quadrants']['axis'] = [
            'midX' => $this->dataGap['stackedBarGap'][0][1],
            'midY' => $this->dataGap['stackedBarGap'][0][0],
        ];

        // end of quadrant

        // getDataDeskripsi
        $survey = Survey::find($this->surveyID);
        $this->dataDeskripsi = [
            'respondenCount' => Entry::where('survey_id', $this->surveyID)->count(),
            'expectedRespondents' => $survey->expected_respondents,
            'surveyName' => $survey->name,
            'surveyYear' => $survey->year,
            'expectedRespondents' => $survey->expectedRespondents,
            'dimensionData' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Harapan',
                        'data' => $rekapitulasiHarapan,
                    ],
                    [
                        'label' => 'Kenyataan',
                        'data' => $rekapitulasiKenyataan,
                    ],
                ],
            ],
            'maxGap' => ['label' => array_keys($gapPerDimensi, max($gapPerDimensi))[0], 'value' => max($gapPerDimensi)],
            'minGap' => ['label' => array_keys($gapPerDimensi, min($gapPerDimensi))[0], 'value' => min($gapPerDimensi)],
            'gapKeseluruhan' => $gapTemp,
        ];

        // get Pie Chart
        $questions = Question::where('survey_id', $this->surveyID)->get();
        // ngambil 1 nilai subdimensi aja
        $subdimensionofSurveiID = $questions->pluck('subdimension_id')->unique()->first();
        $subdimensionofSurvei = Subdimension::find($subdimensionofSurveiID);
        $dimensionofSurvei = $subdimensionofSurvei->dimension->id;
        // dd($dimensionofSurvei);
        $this->dimensionofSurvei = $dimensionofSurvei;
    }

    public function generateChart()
    {
        // $rules = [
        //     'surveyID' => 'required|not_in:',
        // ];
        // $messages = [
        //     'required' => ':attribute wajib diisi.',
        //     'min' => ':attribute minimal wajib :min karakter.',
        //     'not_in' => ':attribute wajib memiliki nilai yang valid.',
        // ];
        // $attributes = [
        //     'surveyID' => 'Survei',
        // ];
        // $this->validate($rules, $messages, $attributes);
        $this->getDataChart();
        $this->dispatch('chartUpdated', $this->dataGap);
    }

    public function getDataPieChartDimension()
    {
        $questions = Question::where('survey_id', $this->surveyID)->get();
    }


    public function generatePieChartDimension()
    {
        $rules = [
            'subDimension' => 'required|not_in:',
        ];
        $messages = [
            'required' => ':attribute wajib diisi.',
            'min' => ':attribute minimal wajib :min karakter.',
            'not_in' => ':attribute wajib memiliki nilai yang valid.',
        ];
        $attributes = [
            'subDimension' => 'Dimensi',
        ];
        $this->validate($rules, $messages, $attributes);

        // Mengambil semua pertanyaan yang terkait dengan survei yang dipilih
        $questionsHarapan = Question::where('survey_id', $this->surveyID)->where('subdimension_id', $this->subDimension)->where('question_type_id', 2)->pluck('id');
        $questionsKenyataan = Question::where('survey_id', $this->surveyID)->where('subdimension_id', $this->subDimension)->where('question_type_id', 3)->pluck('id');

        // Mengambil semua jawaban yang memiliki pertanyaan yang terkait dengan survei yang dipilih
        $answersHarapan = Answer::whereIn('question_id', $questionsHarapan)->orderBy('value', 'asc')->get();
        $answersKenyataan = Answer::whereIn('question_id', $questionsKenyataan)->orderBy('value', 'asc')->get();

        // Mengelompokkan jawaban berdasarkan nilai
        $answersGroupedHarapan = $answersHarapan->groupBy('value')->map(function ($answers) {
            return $answers->count();
        });


        $answersGroupedKenyataan = $answersKenyataan->groupBy('value')->map(function ($answers) {
            return $answers->count();
        });

        // dd($answersGroupedHarapan, $answersGroupedHarapanPersentase, $answersGroupedKenyataan, $answersGroupedKenyataanPersentase);

        $QuestionPertama = Question::where('survey_id', $this->surveyID)->where('question_type_id', 2)->first();

        $AnswerOptionValues = $QuestionPertama->answeroption->answeroptionvalues;
        // dd($AnswerOptionValues);
        $names = $AnswerOptionValues->map(function ($AnswerOptionValues) {
            return $AnswerOptionValues->name;
        })->values()->all(); // Menghapus kembali kunci indeks, lalu memulai kembali dari 0
        // dd($names);

        $chartHarapan = [];
        foreach ($names as $key => $value) {
            foreach ($answersGroupedHarapan as $key2 => $value2) {
                if ($key + 1 == $key2) {
                    $this->dataChartPieDimension['Harapan'][$value] = $value2;
                    $chartHarapan[] = $value2;
                }
            }
        }

        // $chartKenyataan = [];
        foreach ($names as $key => $value) {
            foreach ($answersGroupedKenyataan as $key2 => $value2) {
                if ($key + 1 == $key2) {
                    $this->dataChartPieDimension['Kenyataan'][$value] = $value2;
                }
            }
        }


        $this->judulsubDimension = Subdimension::find($this->subDimension)->name;
        $this->dispatch('chartPieUpdated', $this->dataChartPieDimension);
    }


    public function dd()
    {
        dd($this->all());
        // $this->dispatch('chartUpdated', 8);
    }

    public function mount()
    {
        // $this->uuid = session('uuid');
        // dd($this->uuid);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        // $surveysWithEntries = Survey::has('entries')->get();
        $surveyHaveHarapanDanKenyataan = Survey::whereHas('questions', function ($query) {
            $query->where('question_type_id', 2);
        })->whereHas('questions', function ($query) {
            $query->where('question_type_id', 3);
        })->get();
        return view('livewire.visualization.v-page', [
            // 'surveys' => $surveysWithEntries,
            // 'surveys' => Survey::all(),
            'surveys' => $surveyHaveHarapanDanKenyataan,
            'lastUpdatedTime' => $this->lastUpdatedTime,
            'subdimensions' => Subdimension::all(),
        ]);
    }
}
