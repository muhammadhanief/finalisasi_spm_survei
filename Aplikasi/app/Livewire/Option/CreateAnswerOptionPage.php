<?php

namespace App\Livewire\Option;

use App\Models\AnswerOption;
use App\Models\AnswerOptionValue;
use Livewire\Attributes\Layout;

use Livewire\Component;

class CreateAnswerOptionPage extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.option.create-answer-option-page', [
            'answerOptions' => AnswerOption::all(),
            'answerOptionValues' => AnswerOptionValue::all()
        ]);
    }
}
