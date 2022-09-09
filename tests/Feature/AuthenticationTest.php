<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Admin;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class AuthenticationTest extends TestCase
{
    use LazilyRefreshDatabase;
    protected $seed = true;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_employees_can_authenticate_using_the_login_screen()
    {
      
        $company = Company::factory()->hasEmployees(3)->create();
        $employee = $company->employees()->first();

        $response = $this->post('/login', [
            'email' => $employee->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
        $response->assertSessionHas('company_id', $employee->company_id);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = CompanyUser::factory()
        ->withRole()
        ->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
