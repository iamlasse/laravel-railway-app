<?php

namespace Tests\Feature\Livewire\Admin;

use App\Http\Livewire\Admin\Plans;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class PlansTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Plans::class);

        $component->assertStatus(200);
    }
}
