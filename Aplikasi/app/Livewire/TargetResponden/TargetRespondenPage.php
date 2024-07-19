<?php

namespace App\Livewire\TargetResponden;

use Livewire\Component;
use App\Models\TargetResponden;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Imports\TargetRespondenImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Entry;
use App\Exports\TargetRespondenExport;

class TargetRespondenPage extends Component
{
    use WithPagination;
    use LivewireAlert;
    use WithFileUploads;

    public $search = '';
    #[Validate('required|mimes:xlsx,xls')]
    public $fileImport;
    #[Validate('required', message: 'Grup wajib dipilih')]
    public $roleId;
    #[Validate('required|exists:roles,id')]
    public $manualRoleId;
    #[Validate('required|max:255')]
    public $manualName;
    #[Validate('required|email|max:255|unique:target_respondens,email')]
    public $manualEmail;
    #[Validate('required|not_in:')]
    public $manualType;
    #[Validate('required|not_in:')]
    public $importType;
    public $selectAllRoles = true;
    public $selectedRoleId = [];

    public function mount()
    {
        $this->selectedRoleId = array_fill_keys($this->getRoleIds(), true);
    }

    public function updatedSelectAllRoles()
    {
        // Logika ketika "Pilih semua" diubah
        if ($this->selectAllRoles) {
            // Jika "Pilih semua" dicentang, setiap role dipilih
            $this->selectedRoleId = array_fill_keys($this->getRoleIds(), true);
        } else {
            // Jika "Pilih semua" tidak dicentang, hapus semua pilihan
            $this->selectedRoleId = [];
        }
    }

    private function getRoleIds()
    {
        $roles = Role::all();
        return $roles->pluck('id')->toArray();
    }

    public function addManual()
    {
        $this->validate([
            'manualRoleId' => ['required', 'exists:roles,id'],
            'manualName' => ['required', 'max:255'],
            'manualEmail' => [
                'required',
                'email',
                'max:255',
                Rule::unique('target_respondens', 'email'),
            ],
            'manualType' => 'required|not_in:',
        ], [
            'manualRoleId.required' => 'Grup harus diisi.',
            'manualRoleId.exists' => 'Grup tidak valid.',
            'manualName.required' => 'Nama harus diisi.',
            'manualName.max' => 'Nama tidak boleh lebih dari :max karakter.',
            'manualEmail.required' => 'Email harus diisi.',
            'manualEmail.email' => 'Email tidak valid.',
            'manualEmail.unique' => 'Email sudah digunakan.',
            'manualType.required' => 'Tipe harus diisi.',
            'manualType.not_in' => 'Tipe tidak valid.',
        ]);

        // Validasi berhasil, buat entri baru
        $emailParts = explode('@', $this->manualEmail,);
        $uniqueId = $emailParts[0] . Str::random(3);

        TargetResponden::create([
            'name' => $this->manualName,
            'email' => $this->manualEmail,
            'role_id' => $this->manualRoleId,
            'unique_code' => $uniqueId,
            'type' => $this->manualType,
        ]);

        $this->alert('success', 'Sukses!', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
            'text' => 'Target Responden Berhasil Ditambahkan',
        ]);

        $this->reset(['manualRoleId', 'manualName', 'manualEmail', 'manualType']);
    }


    public function import()
    {
        $this->validate([
            'fileImport' => [
                'required',
                'mimes:xlsx,xls',
            ],
            'roleId' => [
                'required',
                'exists:roles,id',
            ],
            'importType' => 'required|not_in:',
        ], [
            'fileImport.required' => 'File harus diisi.',
            'fileImport.mimes' => 'Format file harus xlsx atau xls.',
            'roleId.required' => 'Role harus diisi.',
            'roleId.exists' => 'Role tidak valid.',
            'importType.required' => 'Tipe harus diisi.',
            'importType.not_in' => 'Tipe tidak valid.',
        ]);

        $import = new TargetRespondenImport($this->roleId, $this->importType);
        // $import = Excel::import($import, $this->fileImport);
        $import->import($this->fileImport);

        $barisKesalahan = $import->failures()->count();

        $this->alert('success', 'Sukses!', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
            'text' => "Database Responden Berhasil Diimport. Duplikasi : $barisKesalahan",
        ]);
        $this->reset(['fileImport', 'roleId']);
    }

    public function delete($id)
    {
        $targetResponden = TargetResponden::find($id);
        $matchedEntry = Entry::where('target_responden_id', $id)->first();
        if ($matchedEntry) {
            $this->alert('error', 'Gagal!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
                'text' => 'Target Responden tidak dapat dihapus karena sudah digunakan.',
            ]);
            return;
        } else {
            $targetResponden->delete();
            $this->alert('success', 'Sukses!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
                'text' => 'Database Responden Berhasil Dihapus',
            ]);
        }
    }

    public function export()
    {
        return Excel::download(new TargetRespondenExport($this->selectedRoleId), 'export_target_responden.xlsx');
    }

    public function dd()
    {
        dd($this->all());
    }


    #[Layout('layouts.app')]
    public function render()
    {
        $targetRespondens = TargetResponden::where('name', 'like', "%{$this->search}%")
            ->whereIn('role_id', array_keys(array_filter($this->selectedRoleId)))
            ->orderByDesc('role_id')
            ->paginate(10);

        if ($targetRespondens->isNotEmpty()) {
            return view('livewire.target-responden.target-responden-page', [
                'targetRespondens' => $targetRespondens,
                'roles' => Role::all(),
            ]);
        } else {
            session()->flash('gagalSearch', 'Dimensi tidak dapat ditemukan');
            return view('livewire.target-responden.target-responden-page', [
                'targetRespondens' => $targetRespondens,
                'roles' => Role::all(),
            ]);
        }
    }
}
