<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Utils\ToggleSwitch;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Offer;
use Livewire\Livewire;
use Tests\TestCase;

class ToggleSwitchTest extends TestCase
{
    use LazilyRefreshDatabase;
protected $seed = true;
    /** @test */
    public function the_component_can_render()
    {
        $offer = Offer::factory()->create();
        $component = Livewire::test(ToggleSwitch::class, ['model' => $offer, 'attribute' => 'is_current_operator']);

        $component->assertStatus(200);
    }
}
