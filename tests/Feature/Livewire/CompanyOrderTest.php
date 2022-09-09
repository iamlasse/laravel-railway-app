<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use Livewire\Livewire;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Http\Livewire\Company\Order as CompanyOrder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class CompanyOrderTest extends TestCase
{
    use LazilyRefreshDatabase;
    protected $seed = true;

    /** @test */
    public function the_component_can_render()
    {
        $company = Company::factory()->hasOffers(5)->create();
        $user = CompanyUser::factory()->create([
            'company_id' => $company->id,
        ]);
        $company->offers()->first()->update(['is_current_operator' => 1]);
        $company->offers()->latest()->limit(1)->update(['is_current_vaxel' => 1]);
        $this->actingAs($user);
        $component = Livewire::test(CompanyOrder::class);

        $component->assertStatus(200);
        $this->assertEquals($component->selectedOffer->id, $company->offers->first()->id);
    }
}
