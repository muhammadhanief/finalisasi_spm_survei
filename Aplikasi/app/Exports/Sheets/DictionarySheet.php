<?php

namespace App\Exports\Sheets;

use App\Models\Answer;
use App\Models\Survey;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class DictionarySheet implements FromArray, WithHeadings, WithTitle
{
    private $surveyID;
    public $dictionaryArray = [];

    public function __construct(int $surveyID)
    {
        $this->surveyID = $surveyID;
    }

    public function getDictionary()
    {
        $array = [];
        $survey = Survey::find($this->surveyID);
        $questions = $survey->questions;
        foreach ($questions as $key => $question) {
            $row = [];
            // start untuk rumus kode pertanyaan
            $questionSectionID = $question->section->id;
            // mengganti questionID dengan key saja
            $questionID = $key + 1;
            $questionTypeID = $question->questionType->id;
            if ($questionTypeID == 1) {
                $questionTypeID = 'U';
            } else if ($questionTypeID == 2) {
                $questionTypeID = 'H';
            } else {
                $questionTypeID = 'K';
            }
            $row[] = 'B' . $questionSectionID . 'P' . $questionID  . $questionTypeID;
            // end untuk rumus kode pertanyaan
            // start for question content
            $row[] = $question->content;
            // end for question content
            // start for question type
            $row[] = $question->questionType->name;
            // end for question type
            // start for dimension
            $row[] = $question->subdimension->name;
            // end for dimension
            // for adding into array
            $array[] = $row;
        }
        $this->dictionaryArray = $array;
        // dd($this->dictionaryArray);
    }

    public function array(): array
    {
        $this->getDictionary();
        return $this->dictionaryArray;
    }

    public function headings(): array
    {
        return [
            'Kode Pertanyaan',
            'Pertanyaan',
            'Tipe Pertanyaan',
            'Dimensi',
        ];
    }

    public function title(): string
    {
        return 'Kamus';
    }
}
