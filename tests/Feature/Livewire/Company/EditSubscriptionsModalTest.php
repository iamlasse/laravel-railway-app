<?php

namespace Tests\Feature\Livewire\Company;

use App\Http\Livewire\Company\EditSubscriptionsModal;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class EditSubscriptionsModalTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected $seed = true;

    /** @test */
    public function the_component_can_render()
    {
        $subscriptions = Subscription::whereCompanyId(1)->pluck('id');
        
        $component = Livewire::test(EditSubscriptionsModal::class, [
            'subscriptions' => $subscriptions,
            'all' => true,
            'operatorId' => 1,
        ]);

        $component->assertStatus(200);
    }
}
