<?php

namespace Tests\Feature\Livewire;

use App\Livewire\VisualizationTest;
use App\Livewire\Visualization\VPage;
use App\Models\Subdimension;
use App\Models\Survey;
use Livewire\Livewire;
use Tests\TestCase;

class VisualizationTestTest extends TestCase
{
    /** @test */
    public function it_renders_the_vpage_component()
    {
        // Uji apakah komponen Livewire dirender dengan benar
        Livewire::test(VPage::class)
            ->assertSee('Visualisasi');
    }
}
