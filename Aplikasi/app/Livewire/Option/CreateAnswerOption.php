<?php

namespace App\Livewire\Option;

use Livewire\Attributes\Validate;
use App\Models\AnswerOption;
use App\Models\AnswerOptionValue;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use Livewire\Component;



class CreateAnswerOption extends Component
{
    use LivewireAlert;
    #[Validate('min:3')]
    public $name = '';
    #[Validate('required|not_in:')]
    public $type = '';
    // #[Validate('required|array')]
    public $options = [];

    public function validateOption()
    {
        $rules = [
            'name' => 'required|min:3',
            'type' => 'required|not_in:',
            'options.*' => 'required|min:3',
            // 'options' => 'required|array',
        ];

        $messages = [
            'name.required' => 'Nama wajib diisi.',
            'name.min' => 'Nama minimal harus memiliki 3 karakter.',
            'type.required' => 'Tipe wajib diisi.',
            'type.not_in' => 'Tipe tidak boleh kosong.',
            'options.*.required' => 'Nilai pada opsi wajib diisi.',
            'options.*.min' => 'Nilai pada opsi minimal harus memiliki 3 karakter.',
            'options.required' => 'Opsi harus ada.',
            'options.array' => 'Opsi harus ada.',
        ];
        $this->validate($rules, $messages);
    }

    public function addOption()
    {
        $this->options[] = [];
    }

    public function deleteOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function create()
    {
        // dd($this->all());
        $this->validateOption();
        $answerOption = AnswerOption::create([
            'name' => $this->name,
            'type' => $this->type,
        ]);
        $answerOptionID = $answerOption->id;
        foreach ($this->options as $key => $options) {
            AnswerOptionValue::create([
                'name' => $options,
                'answer_option_id' => $answerOptionID,
                'value' => $key + 1,
            ]);
        }
        $this->dispatch('optionCreated');
        $this->reset();
        $this->alert('success', 'Sukses!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => true,
            'text' => 'Opsi Jawaban sukses dibuat.',
        ]);
    }

    public function render()
    {
        return view('livewire.option.create-answer-option');
    }
}
