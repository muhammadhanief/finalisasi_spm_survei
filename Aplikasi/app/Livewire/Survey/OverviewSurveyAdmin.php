<?php

namespace App\Livewire\Survey;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Models\Survey;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class OverviewSurveyAdmin extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $search = '';

    public function monitoring($surveyID)
    {
        $this->redirectRoute('survey.monitoring', ['surveyID' => $surveyID]);
    }

    public function detail($surveyID)
    {
        // return redirect()->route('survey.detail', $surveyID);
        $survey = Survey::find($surveyID);
        $started_at_parsed = \Carbon\Carbon::parse($survey->started_at);
        if ($started_at_parsed->isPast()) {
            // session()->flash('errorHapus', 'survey tidak dapat dihapus karena sudah dimulai');
            $this->alert('error', 'Gagal!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => true,
                'text' => 'Survey tidak dapat diedit karena sudah dimulai/selesai',
            ]);
        } else {
            $this->redirectRoute('survey.detail', ['surveyID' => $surveyID]);
        }
    }

    public function delete($surveyID)
    {
        $survey = Survey::find($surveyID);
        $started_at_parsed = \Carbon\Carbon::parse($survey->started_at);
        if ($started_at_parsed->isPast()) {
            // session()->flash('errorHapus', 'survey tidak dapat dihapus karena sudah dimulai');
            $this->alert('error', 'Gagal!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => true,
                'text' => 'Survey tidak dapat dihapus karena sudah dimulai/selesai',
            ]);
        } else {
            foreach ($survey->questions as $question) {
                $question->answers()->delete();
            }
            $survey->questions()->delete();
            $survey->sections()->delete();
            $survey->entries()->delete();
            $survey->delete();
            // session()->flash('successHapus', 'survey berhasil dihapus.');
            $this->alert('success', 'Sukses!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => true,
                'text' => 'Survey sukses dihapus.',
            ]);
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $surveys = Survey::where('name', 'like', "%{$this->search}%")
            // ->orderBy('started_at', 'asc')
            ->latest()
            ->paginate(5);
        if ($surveys->isNotEmpty()) {
            return view('livewire.survey.overview-survey-admin', [
                'surveys' => $surveys
            ]);
        } else {
            session()->flash('gagalSearch', 'Survei tidak dapat ditemukan');
            return view('livewire.survey.overview-survey-admin', [
                'surveys' => $surveys
            ]);
        }
    }
}
