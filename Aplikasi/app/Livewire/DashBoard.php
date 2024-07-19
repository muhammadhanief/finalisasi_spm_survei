<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Survey;
use App\Models\Entry;
use App\Models\User;

class DashBoard extends Component
{

    #[Layout('layouts.app')]
    public function render()
    {
        $surveys = Survey::all();
        $countSurvey = $surveys->count();
        $canFilledSurvey = $surveys->where('ended_at', '>', now())->count();
        $totalEntry  = Entry::all()->count();
        $totalUser = User::all()->count();
        return view('livewire.dash-board', [
            'countSurvey' => $countSurvey,
            'canFilledSurvey' => $canFilledSurvey,
            'totalEntry' => $totalEntry,
            'totalUser' => $totalUser,
        ]);
    }
}
