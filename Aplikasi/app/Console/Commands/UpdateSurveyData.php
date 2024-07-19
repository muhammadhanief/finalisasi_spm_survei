<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Subdimension;
use App\Models\Survey;
use App\Models\Entry;

class UpdateSurveyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:update-survey-data';
    protected $signature = 'survey:update-all-data';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update hasil survei setiap 5 menit sehingga tidak memberatkan server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ini_set('memory_limit', '1G');
        set_time_limit(60 * 5); // Set time limit to 5 minutes

        $surveys = Survey::all();

        foreach ($surveys as $survey) {
            $surveyID = $survey->id;

            $questionHarapan = Question::where('survey_id', $surveyID)->where('question_type_id', 2)->get();
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

            $questionKenyataan = Question::where('survey_id', $surveyID)->where('question_type_id', 3)->get();
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

            $dataGap['radar'] = [
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

            $dataGap['stackedBarGap'] = [
                $nilai = [$noDimensiRekapitulasiHarapan, $noDimensiRekapitulasiKenyataan,],
                $gap = [$gapHarapan, $gapKenyataan,],
            ];

            $gapPerDimensi = [];

            foreach ($dataGap['radar']['labels'] as $key => $label) {
                $gap = abs($dataGap['radar']['datasets'][1]['data'][$key] - $dataGap['radar']['datasets'][0]['data'][$key]);
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

            $dataGap['quadrants']['data'] = [
                'datasets' => $newData,
            ];
            $dataGap['quadrants']['axis'] = [
                'midX' => $dataGap['stackedBarGap'][0][1],
                'midY' => $dataGap['stackedBarGap'][0][0],
            ];

            // end of quadrant

            // getDataDeskripsi
            $dataDeskripsi = [
                'respondenCount' => Entry::where('survey_id', $surveyID)->count(),
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

            // Add dataDeskripsi as a child of dataGap
            $dataGap['dataDeskripsi'] = $dataDeskripsi;

            // get Pie Chart
            $questions = Question::where('survey_id', $surveyID)->get();
            // ngambil 1 nilai subdimensi aja
            $subdimensionofSurveiID = $questions->pluck('subdimension_id')->unique()->first();
            $subdimensionofSurvei = Subdimension::find($subdimensionofSurveiID);
            $dimensionofSurvei = $subdimensionofSurvei->dimension;
            $dataGap['dimensionofSurvei'] = $dimensionofSurvei->id;

            // Update survey data
            $survey->data_gap = json_encode($dataGap);
            $survey->save();

            // Log success message
            $this->info("Survey data updated successfully for survey ID: {$surveyID}");
        }
    }
}
