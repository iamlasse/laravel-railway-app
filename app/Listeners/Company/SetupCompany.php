<?php

namespace App\Listeners\Company;

use App\Models\CompanyUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetupCompany
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
        if (auth()->user() instanceof CompanyUser) {
            $company = company();
            if ($company->hasSelectedOperator()) {
                session()->put('selected_operator', $company->selected_operator);
            }

            if ($company->orderInProgress()) {
                session()->put('order_in_progress', true);
            }
        }
    }
}
