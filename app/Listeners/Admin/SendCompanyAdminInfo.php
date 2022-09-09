<?php

namespace App\Listeners\Admin;

use App\Notifications\Admin\CompanyCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCompanyAdminInfo
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

            // if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail()) {
            //     $event->user->sendEmailVerificationNotification();
            // }

        if ($event->company) {
            $event->company->rep->notify(new CompanyCreated($event->company));
        }
    }
}
