<?php

namespace App\Livewire\Survey;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;

class PageCreateSurvey extends Component
{
    use LivewireAlert;


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.survey.page-create-survey');
    }
}
