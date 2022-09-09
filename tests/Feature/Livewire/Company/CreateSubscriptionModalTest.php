<?php

namespace Tests\Feature\Livewire\Company;

use Tests\TestCase;
use App\Models\Offer;
use Livewire\Livewire;
use App\Models\Company;
use App\Models\CompanyUser;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Livewire\Company\CreateSubscriptionModal;
use Illuminate\Support\Facades\Event;

class CreateSubscriptionModalTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        Event::fake();
        // $company = Company::withoutEvents(fn() => Company::factory()->hasAddress(1)->createQuietly());
         Company::factory()->createQuietly();
        // $company->offers()->create(Offer::factory()->create(['is_current_operator' => true])->toArray());
        // $user = CompanyUser::factory()->create(['company_id' => $company->id]);
        // $user->assignRole(['company-user']);
        // $this->actingAs($user);
        // $component = Livewire::test(CreateSubscriptionModal::class, ['company' => $company]);

        // $component->assertStatus(200);
    }
}
