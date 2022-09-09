<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use Livewire\Livewire;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Http\Livewire\Company\Dashboard as CompanyDashboard;
use App\Models\Subscription;
use Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class CompanyDashboardTest extends TestCase
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
        $company->subscriptions()->createMany(
            Subscription::factory(10)->createQuietly()->toArray()
        );

        $company->offers->first()->update(['is_current_operator' => 1]);
        $this->actingAs($user);
        $component = Livewire::test(CompanyDashboard::class);

        $component->assertStatus(200);
    }
}
