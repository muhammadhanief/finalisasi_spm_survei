<?php

namespace App\Livewire\Testing;

use Livewire\Attributes\Layout;
use App\Models\Survey;

use Livewire\Component;

class TestPersis extends Component
{
    public $apani = '';

    public function store()
    {
        dd($this->all());
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $surveyID = request()->route('surveyID');
        $survey = Survey::find($surveyID);
        return view('livewire.testing.test-persis', ['survey' => $survey]);
    }
}
