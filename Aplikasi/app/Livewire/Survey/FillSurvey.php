<?php

namespace App\Livewire\Survey;

use Livewire\Attributes\Layout;
use App\Models\Survey;
use App\Models\Dimension;
use App\Models\Subdimension;
use App\Models\TargetResponden;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Str;

class FillSurvey extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $search = '';
    public $userInfo;
    public $matchedTargetRespondenInfo;

    public function mount()
    {
        // $userInfo = Auth::user();
        // $this->userInfo = $userInfo;
        // $userEmail = $userInfo->email;
        // $this->matchedTargetRespondenInfo = TargetResponden::where('email', $userEmail)->first();
        // if ($this->matchedTargetRespondenInfo) {
        //     // Jika data ditemukan, update kolom user_id
        //     $this->matchedTargetRespondenInfo->update(['user_id' => $userInfo->id]);
        // }
    }

    public function fillSurvey($surveyID)
    {
        $survey = Survey::find($surveyID);
        $uuid = $survey->uuid;
        $started_at_parsed = \Carbon\Carbon::parse($survey->started_at);
        $ended_at_parsed = \Carbon\Carbon::parse($survey->ended_at);
        if (!$started_at_parsed->isPast() || $ended_at_parsed->isPast()) {
            // session()->flash('errorHapus', 'survey tidak dapat dihapus karena sudah dimulai');
            $this->alert('error', 'Gagal!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => true,
                'text' => 'Survey tidak dapat diisi karena belum dimulai/telah selesai',
            ]);
        } else {
            $this->redirectRoute('survey.fill', ['uuid' => $uuid]);
        }
    }
    public $test = '';

    public function testing()
    {
        dd($this->all());
    }

    #[Layout('layouts.app')]
    public function render()
    {
        // if ($this->matchedTargetRespondenInfo != null) {
        $surveys = Survey::where('name', 'like', "%{$this->search}%")
            // ->whereJsonContains('role_id', $this->matchedTargetRespondenInfo->role_id)
            ->orderBy('started_at', 'asc')
            ->latest()
            ->paginate(5);
        if ($surveys->isNotEmpty()) {
            return view('livewire.survey.fill-survey', [
                'surveys' => $surveys,
                'dimensions' => Dimension::all(),
                'subdimensions' => Subdimension::all(),
            ]);
        } else {
            session()->flash('gagalSearch', 'Survei tidak dapat ditemukan');
            return view('livewire.survey.fill-survey', [
                'surveys' => $surveys,
                'dimensions' => Dimension::all(),
                'subdimensions' => Subdimension::all(),
            ]);
        }
    }
}
