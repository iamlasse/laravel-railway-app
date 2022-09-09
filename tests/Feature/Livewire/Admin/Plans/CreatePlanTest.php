<?php

namespace Tests\Feature\Livewire\Admin\Plans;

use App\Http\Livewire\Admin\Plans\CreatePlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreatePlanTest extends TestCase
{
    /** @test */
    public function theComponentCanRender()
    {
        $component = Livewire::test(CreatePlan::class, ['operator' => operators()->first()]);

        $component->assertStatus(200);
    }
}
