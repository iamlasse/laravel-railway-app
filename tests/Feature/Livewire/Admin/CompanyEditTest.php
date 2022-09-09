<?php

namespace Tests\Feature\Livewire\Admin;

use App\Http\Livewire\Admin\CompanyEdit;
use App\Models\Admin;
use App\Models\Company;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CompanyEditTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected $seed = true;
    /** @test */
    public function the_component_can_render()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin);
        $company = Company::factory()->hasAddress(1)->create();
        $component = Livewire::test(CompanyEdit::class, ['company' => $company]);

        $component->assertStatus(200);
    }
}
