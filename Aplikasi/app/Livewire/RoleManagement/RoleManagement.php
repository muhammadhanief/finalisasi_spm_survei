<?php

namespace App\Livewire\RoleManagement;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class RoleManagement extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $search = '';

    public function setAdmin($userID)
    {
        $user = User::find($userID);
        if ($user) {
            Log::info('User found: ' . $user->id);
            $user->removeRole('User');
            $user->removeRole('Operator');
            $user->assignRole('Admin');
            $this->alert('success', 'Berhasil!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => true,
                'text' => 'Role berhasil diubah menjadi admin',
            ]);
        } else {
            Log::error('User not found with ID: ' . $userID);
            $this->alert('error', 'Gagal!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => true,
                'text' => 'Pengguna tidak ditemukan',
            ]);
        }
    }

    public function setUser($userID)
    {
        $user = User::find($userID);
        $user->removeRole('Admin');
        $user->removeRole('Operator');
        $user->assignRole('User');
        $this->alert('success', 'Berhasil!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => true,
            'text' => 'Role berhasil diubah menjadi user',
        ]);
    }


    public function setOperator($userID)
    {
        $user = User::find($userID);
        $user->removeRole('User');
        $user->removeRole('Admin');
        $user->assignRole('Operator');
        $this->alert('success', 'Berhasil!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => true,
            'text' => 'Role berhasil diubah menjadi operator',
        ]);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $users = User::where('name', 'like', "%{$this->search}%")
            ->orderBy('created_at', 'asc')
            ->latest()
            ->paginate(20);
        if ($users->isEmpty()) {
            session()->flash('gagalSearch', 'Survei tidak dapat ditemukan');
        }
        return view('livewire.role-management.role-management', [
            'users' => $users,
        ]);
    }
}
