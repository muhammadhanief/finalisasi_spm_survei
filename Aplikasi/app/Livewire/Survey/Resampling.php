<?php

namespace App\Livewire\Survey;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Resampling extends Component
{

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.survey.resampling');
    }
}
