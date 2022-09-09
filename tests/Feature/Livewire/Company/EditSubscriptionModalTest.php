<?php

namespace Tests\Feature\Livewire\Company;

use App\Http\Livewire\Company\EditSubscriptionModal;
use App\Models\CompanyUser;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class EditSubscriptionModalTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $user = CompanyUser::factory()->create();
        $user->assignRole('company-user');

        $subscription = Subscription::factory()->create();
        $this->actingAs($user);
        $component = Livewire::test(EditSubscriptionModal::class, ['subscriptionId' => $subscription->id]);
        
        $component->assertStatus(200);
    }
}
