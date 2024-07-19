<?php

namespace App\Livewire\Survey;

use Livewire\Component;
use App\Models\Dimension;
use App\Models\Subdimension;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Mail;
use App\Mail\RespondenSurveyAnnounceFirst;
use Livewire\WithPagination;

class DimensionsList extends Component
{
    use WithPagination;
    use LivewireAlert;

    #[Validate]
    public $name = '';
    #[Validate]
    public $description = '';
    public $search = '';

    public $editingDimensionID;
    public $editingDimensionDescription;

    public function rules()
    {
        return [
            'name' => [
                'required',
                Rule::unique('dimensions')
            ],
            'description' => [
                'required',
            ],
        ];
    }

    public function create()
    {
        // $this->validate();
        $this->validate([
            'name' => 'required|unique:dimensions',
            'description' => 'required'
        ]);
        // Dimension::create($this->all());
        Dimension::create([
            'name' => $this->name,
            'description' => $this->description
        ]);
        $this->reset('name', 'description');
        // session()->flash('success', 'Dimensi sukses ditambahkan.');
        $this->alert('success', 'Sukses!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => true,
            'text' => 'Kategori dimensi sukses ditambahkan.',
        ]);
        $this->dispatch('reloadDimension');
        // return redirect()->route('dimensi');
    }

    public function delete($dimensionID)
    {
        $dimensi = Dimension::find($dimensionID);
        if ($dimensi->subdimensions()->count() > 0) {
            $canDelete = true;
            foreach ($dimensi->subdimensions as $subdimension) {
                if ($subdimension->questions()->count() > 0) {
                    $canDelete = false;
                }
            }
            if ($canDelete) {
                foreach ($dimensi->subdimensions as $subdimension) {
                    $subdimension->delete();
                }
                $dimensi->delete();
                $this->alert('success', 'Sukses!', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => true,
                    'text' => 'Kategori Dimensi dan Dimensi Berhasil Dihapus',
                ]);
            } else {
                $this->alert('error', 'Gagal!', [
                    'position' => 'center',
                    'timer' => 4000,
                    'toast' => true,
                    'text' => 'Dimensi tidak dapat dihapus karena telah digunakan di pertanyaan.',
                ]);
            }
        } else {
            $dimensi->delete();
            $this->alert('success', 'Sukses!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
                'text' => 'Dimensi Berhasil Dihapus',
            ]);
        }
    }

    public function deleteSubdimension($subdimensionID)
    {
        $subdimensi = Subdimension::find($subdimensionID);
        if ($subdimensi->questions()->count() > 0) {
            // session()->flash('errorHapus', 'Subdimensi tidak dapat dihapus karena telah digunakan di pertanyaan.');
            $this->alert('error', 'Gagal!', [
                'position' => 'center',
                'timer' => 3500,
                'toast' => true,
                'text' => 'Dimensi tidak dapat dihapus karena telah digunakan di pertanyaan.',
            ]);
        } else {
            $subdimensi->delete();
            $this->alert('success', 'Sukses!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
                'text' => 'Dimensi Berhasil Dihapus',
            ]);
        }
    }

    public function edit($dimensionID)
    {
        $this->editingDimensionID = $dimensionID;
        $dimensi = Dimension::find($dimensionID);
        $this->editingDimensionDescription = $dimensi->description;
    }

    public function cancelEdit()
    {
        $this->reset('editingDimensionID', 'editingDimensionDescription');
    }
    public function update($dimensionID)
    {
        $this->validate([
            'editingDimensionDescription' => 'required'
        ]);

        Dimension::find($dimensionID)->update([
            'description' => $this->editingDimensionDescription
        ]);
        $this->cancelEdit();
        // session()->flash('successUpdate', [
        //     'message' => 'Deskripsi Dimensi berhasil diubah.',
        //     'dimensionID' => $dimensionID
        // ]);

        $this->alert('success', 'Sukses!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => true,
            'text' => 'Kategori dimensi sukses diupdate.',
        ]);
    }

    // FOR SUBDIMENSION
    #[Validate('required|not_in:')]
    public $dimensionID;
    #[Validate('required')]
    public $subdimensionName = '';
    #[Validate('required')]
    public $subdimensionDescription = '';
    public function createSubdimension()
    {
        $rules = [
            'dimensionID' => 'required|not_in:',
            'subdimensionName' => 'required',
            'subdimensionDescription' => 'required'
        ];

        $messages = [
            'required' => ':attribute wajib diisi.',
            'min' => ':attribute minimal wajib :min karakter.',
            'not_in' => ':attribute wajib memiliki nilai yang valid.',
        ];

        $attributes = [
            'dimensionID' => 'Dimensi Induk',
            'subdimensionName' => 'Nama Subdimensi',
            'subdimensionDescription' => 'Deskripsi Subdimensi',
        ];

        $this->validate($rules, $messages, $attributes);

        Subdimension::create([
            'name' => $this->subdimensionName,
            'description' => $this->subdimensionDescription,
            'dimension_id' => $this->dimensionID
        ]);
        $this->reset('subdimensionName', 'subdimensionDescription', 'dimensionID');
        $this->dispatch('resetDimensionID');
        $this->alert('success', 'Sukses!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => true,
            'text' => 'Dimensi sukses ditambahkan.',
        ]);
    }

    // Utuk Modal Subdimensi
    public $showingDimensionID = '';
    public $showingDimensionName = '';

    public function showSubdimensionModal($dimensionID)
    {
        $this->showingDimensionID = $dimensionID;
        $dimensi = Dimension::find($dimensionID);
        $this->showingDimensionName = $dimensi->name;
    }

    public function dd()
    {
        dd($this->dimensionID);
    }


    #[Layout('layouts.app')]
    public function render()
    {
        $dimensions = Dimension::withCount('subdimensions as questions_count')
            ->where('name', 'like', "%{$this->search}%")
            ->orderByDesc('questions_count')
            ->latest()
            ->paginate(5);
        $dimensionsNotPaginate = Dimension::all();
        if ($dimensions->isNotEmpty()) {
            return view('livewire.survey.dimensions-list', [
                'dimensions' => $dimensions,
                'dimensionsNotPaginate' => $dimensionsNotPaginate,
                'subdimensions' => Subdimension::all(),
            ]);
        } else {
            session()->flash('gagalSearch', 'Dimensi tidak dapat ditemukan');
            return view('livewire.survey.dimensions-list', [
                'dimensions' => $dimensions,
                'dimensionsNotPaginate' => $dimensionsNotPaginate,
                'subdimensions' => Subdimension::all(),
            ]);
        }
    }
}