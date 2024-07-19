<?php

namespace App\Livewire\Option;

use Livewire\Component;
use App\Models\AnswerOption;
use App\Models\AnswerOptionValue;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SearchAnswerOption extends Component
{
    use WithPagination;
    use LivewireAlert;

    protected $listeners = ['optionCreated' => 'refreshSearch'];
    public $search;
    // Utuk Modal Subdimensi
    public $showingAnswerOptionID = '';
    public $showingAnswerOptionName = '';

    public function showAnswerOptionValueModal($answerOptionID)
    {
        $this->showingAnswerOptionID = $answerOptionID;
        $answerOption = AnswerOption::find($answerOptionID);
        $this->showingAnswerOptionName = $answerOption->name;
    }

    public function deleteAnswerOptionValue($answerOptionValueID)
    {
        $answerOptionValue = AnswerOptionValue::find($answerOptionValueID);
        $answerOption = $answerOptionValue->answeroption;
        $canDelete = true;
        if ($answerOption->questions()->count() > 0) {
            $canDelete = false;
        }
        if ($canDelete) {
            $answerOptionValue->delete();
            $this->alert('success', 'Sukses!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
                'text' => 'Opsi Jawaban Berhasil Dihapus',
            ]);
        } else {
            $this->alert('error', 'Gagal!', [
                'position' => 'center',
                'timer' => 4000,
                'toast' => true,
                'text' => 'Opsi Jawaban Gagal dihapus Karena digunakan di jawaban',
            ]);
        }
    }

    public function delete($answerOptionID)
    {
        $answerOption = AnswerOption::find($answerOptionID);
        $canDelete = true;
        // foreach ($answerOption->answeroptionvalues as $answeroptionvalue) {
        if ($answerOption->questions()->count() > 0) {
            $canDelete = false;
        }
        if ($canDelete) {
            foreach ($answerOption->answeroptionvalues as $answeroptionvalue) {
                $answeroptionvalue->delete();
            }
            $answerOption->delete();
            $this->alert('success', 'Sukses!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
                'text' => 'Paket Opsi Jawaban Berhasil Dihapus',
            ]);
        } else {
            $this->alert('error', 'Gagal!', [
                'position' => 'center',
                'timer' => 4000,
                'toast' => true,
                'text' => 'Paket Opsi Jawaban Gagal dihapus Karena digunakan di jawaban',
            ]);
        }
    }

    public function refreshSearch()
    {
        $this->render();
    }

    public function render()
    {
        $answerOption = AnswerOption::where('name', 'like', '%' . $this->search . '%')->paginate(5);
        if ($answerOption->isNotEmpty()) {
            return view('livewire.option.search-answer-option', [
                'answerOptions' => $answerOption,
                'answerOptionValues' => AnswerOptionValue::all(),
            ]);
        } else {
            session()->flash('gagalSearch', 'Paket jawaban tidak dapat ditemukan');
            return view('livewire.option.search-answer-option', [
                'answerOptions' => $answerOption,
                'answerOptionValues' => AnswerOptionValue::all(),
            ]);
        }
    }
}
