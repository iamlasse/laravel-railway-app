<?php

namespace Tests\Feature\Livewire\Admin;

use App\Http\Livewire\Admin\CreateSubscriptionModal;
use App\Models\Company;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateSubscriptionModalTest extends TestCase
{

    use LazilyRefreshDatabase;
    protected $seed = true;
    /** @test */
    public function the_component_can_render()
    {
        $company = Company::factory()->hasOffers(5)->create();
        $company->offers->first()->update(['is_current_operator' => 1]);
        
        $component = Livewire::test(CreateSubscriptionModal::class, ['companyId' => $company->id]);

        $component->assertStatus(200);
    }
}
