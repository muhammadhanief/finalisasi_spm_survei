<?php

namespace App\Livewire\Survey;

use Livewire\Component;

class DetailSurvey extends Component
{
    public function render()
    {
        $surveyID = request()->route('surveyID');
        return view('livewire.survey.detail-survey', [
            'surveyID' => $surveyID,
        ]);
    }
}