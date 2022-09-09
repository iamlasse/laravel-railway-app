<?php

namespace App\Providers;

use App\Events\Admin\CompanyCreated;
use App\Events\Admin\CompanyStarted;
use App\Listeners\Admin\SendCompanyAdminInfo;
use App\Listeners\Company\SendCompanyInvite;
use App\Listeners\Company\SetupCompany;
use App\Listeners\Company\SetTenantId;
use App\Models\Company;
use App\Observers\CompanyObserver;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Login::class => [
            SetTenantId::class,
            SetupCompany::class,
        ],
        CompanyCreated::class => [
            SendCompanyAdminInfo::class
        ],
        CompanyStarted::class => [
            SendCompanyInvite::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        if (!app()->runningInConsole()) {
            Company::observe(CompanyObserver::class);
        }
    }
}
