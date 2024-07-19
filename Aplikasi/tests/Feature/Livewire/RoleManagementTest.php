<?php

namespace Tests\Feature\Livewire;

use App\Livewire\RoleManagement\RoleManagement;
use App\Livewire\Survey\DimensionsList;
use App\Models\User;
use Faker\Factory;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleManagementTest extends TestCase
{
    /** @test */
    public function it_sets_user_role_to_admin()
    {
        // Buat pengguna baru dengan peran 'User' dan 'Operator'
        $user = User::factory()->create();
        $user->assignRole('User');
        $user->assignRole('Operator');

        // Pastikan pengguna memiliki peran 'User' dan 'Operator'
        $this->assertTrue($user->hasRole('User'));
        $this->assertTrue($user->hasRole('Operator'));

        // Panggil metode setAdmin pada komponen RoleManagement
        Livewire::test(RoleManagement::class) // Jika RoleManagement menggunakan namespace, pastikan untuk menyesuaikan string ini.
            // ->skipRender() // Menghindari rendering view
            ->call('setAdmin', $user->id);

        // Refresh instance pengguna dari database
        $user->refresh();

        // Pastikan pengguna tidak lagi memiliki peran 'User' dan 'Operator'
        $this->assertFalse($user->hasRole('User'));
        $this->assertFalse($user->hasRole('Operator'));

        // Pastikan pengguna memiliki peran 'Admin'
        $this->assertTrue($user->hasRole('Admin'));
    }
}
