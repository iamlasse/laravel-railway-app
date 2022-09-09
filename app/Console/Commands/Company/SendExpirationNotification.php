<?php

namespace App\Console\Commands\Company;

use App\Models\Company;
use App\Notifications\Company\OfferExpiredNotification;
use Illuminate\Console\Command;

class SendExpirationNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company:send-notifications {--expired}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends notifications to companies that have expiring offers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $companies = Company::query()->whereNotNull('offer_ends_at')->whereNull('offer_expired_at')->whereDate('offer_ends_at', now())->get();

        foreach ($companies as $company) {
            if ($company->contact) {
                // $company->contact->notify(new \App\Notifications\Company\OfferExpiringNotification($company));
                $company->contact->notify(new OfferExpiredNotification($company));
                $company->offer_expired_at = now();
                $company->save();
            }

            $this->info('Notified ' . $company->contact->email);
        }

        $this->info($companies->count() . ' Notifications sent');
        return 0;
    }
}
