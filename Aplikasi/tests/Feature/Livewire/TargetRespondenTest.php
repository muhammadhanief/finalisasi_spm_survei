<?php

namespace Tests\Feature\Livewire;

use App\Livewire\TargetResponden\TargetRespondenPage;
use App\Models\Entry;
use App\Models\Role;
use App\Models\TargetResponden;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TargetRespondenTest extends TestCase
{
    /** @test */
    public function it_creates_a_new_target_responden()
    {
        $role_id = Role::find(1)->id;

        Livewire::test(TargetRespondenPage::class)
            ->set('manualRoleId', $role_id)
            ->set('manualName', 'John Doe')
            ->set('manualEmail', 'john@example.com')
            ->set('manualType', 'individual')
            ->call('addManual');

        $this->assertDatabaseHas('target_respondens', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role_id' => $role_id,
            'type' => 'individual',
        ]);
    }

    /** @test */
    public function it_deleted_a_target_responden()
    {
        $targetRespondenRandom = TargetResponden::inRandomOrder()->first();
        $matchedEntry = Entry::where('target_responden_id', $targetRespondenRandom->id)->first();
        Livewire::test(TargetRespondenPage::class)
            ->call('delete', $targetRespondenRandom->id);
        if ($matchedEntry) {
            $this->assertDatabaseHas('target_respondens', ['id' => $targetRespondenRandom->id]);
        } else {
            $this->assertDatabaseMissing('target_respondens', ['id' => $targetRespondenRandom->id]);
        }
    }
}
