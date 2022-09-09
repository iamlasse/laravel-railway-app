<?php

namespace App\Listeners\Company;

use App\Models\Company;
use App\Notifications\Company\WelcomeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCompanyInvite
{
    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle($event)
    {
        $event->company->contact->notify(new WelcomeNotification($event->company));
    }
}
