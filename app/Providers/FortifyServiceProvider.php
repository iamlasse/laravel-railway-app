<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Livewire\Auth\Login;
use App\Models\User;
use Hash;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Livewire;
use Livewire\LivewireManager;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->instance(
            LoginResponse::class,
            new class implements LoginResponse {
                public function toResponse($request)
                {
                    if (auth()->user()->hasRole('super-admin')) {
                        return redirect()->intended(route('system.home'));
                    }


                    if (auth()->user()->hasRole('company-admin')) {
                        return redirect()->intended(route('admin.dashboard'));
                    }


                    return redirect()->intended(config('fortify.home'));
                }
            }
        );

        // $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
        //     public function toResponse($request)
        //     {



        //         return redirect(RouteServiceProvider::HOME);
        //     }
        // });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for(
            'login',
            function (Request $request) {
                return Limit::perMinutes(5, 5)->by($request->email . $request->ip());
            }
        );

        RateLimiter::for(
            'two-factor',
            function (Request $request) {
                return Limit::perMinute(5)->by($request->session()->get('login.id'));
            }
        );

        // $this->app->instance(LoginViewResponse::class, new class implements LoginViewResponse {
        //     public function toResponse($request)
        //     {
        //         return (new Login)(app(), $request->route());
        //     }
        // });

        // Fortify::authenticateUsing(function (Request $request) {
        //     $user = User::where('email', $request->email)->first();

        //     dd($user->can('view companies'));

        //     if ($user &&
        //         Hash::check($request->password, $user->password)) {
        //         return $user;
        //     }
        // });
    }
}
