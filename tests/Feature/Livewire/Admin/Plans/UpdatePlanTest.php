<?php

namespace Tests\Feature\Livewire\Admin\Plans;

use App\Http\Livewire\Admin\Plans\UpdatePlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class UpdatePlanTest extends TestCase
{
    /** @test */
    public function theComponentCanRender()
    {
        $component = Livewire::test(UpdatePlan::class, ['planId' => 1]);

        $component->assertStatus(200);
    }
}
