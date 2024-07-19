<?php

namespace App\Livewire\Survey\CopySurvey;

use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;

class EditingCopySurvey extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $oldSurveyID;

    public function mount($oldSurveyID)
    {
        $this->oldSurveyID = $oldSurveyID;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.survey.copy-survey.editing-copy-survey');
    }
}
