<?php

namespace App\Livewire\Survey\CopySurvey;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Survey;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PageCopySurvey extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $search = '';
    public $showingSurveyID;

    public function detailPreview($surveyID)
    {
        $this->showingSurveyID = $surveyID;
    }

    public function closeDetailPreview()
    {
        $this->reset('showingSurveyID');
    }

    public function copySurvey()
    {
        // $this->redirectRoute('survey.copy.detail', ['oldSurveyID' => $this->showingSurveyID]);
        $this->redirectRoute('survey.create', ['oldSurveyID' => $this->showingSurveyID]);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $surveys = Survey::where('name', 'like', "%{$this->search}%")
            ->orderBy('started_at', 'asc')
            ->latest()
            ->paginate(5);
        if ($surveys->isNotEmpty()) {
            return view('livewire.survey.copy-survey.page-copy-survey', [
                'surveys' => $surveys,
            ]);
        } else {
            session()->flash('gagalSearch', 'Survei tidak dapat ditemukan');
            return view('livewire.survey.copy-survey.page-copy-survey', [
                'surveys' => $surveys,
            ]);
        }
    }
}
