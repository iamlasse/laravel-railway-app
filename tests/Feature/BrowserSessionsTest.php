<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Models\CompanyUser;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Laravel\Jetstream\Http\Livewire\LogoutOtherBrowserSessionsForm;

class BrowserSessionsTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected $seed = true;

    public function test_other_browser_sessions_can_be_logged_out()
    {
        
        $this->actingAs($user = CompanyUser::factory()->create());

        Livewire::test(LogoutOtherBrowserSessionsForm::class)
                ->set('password', 'password')
                ->call('logoutOtherBrowserSessions');
    }
}
