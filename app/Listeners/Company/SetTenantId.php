<?php

namespace App\Listeners\Company;

use App\Models\CompanyUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetTenantId
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->user instanceof CompanyUser) {
            session()->put('company_id', $event->user->company_id);
        }
    }
}
