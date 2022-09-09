<?php

namespace App\Jobs;

use App\Models\Company;
use App\Models\Offer;
use App\Models\Plan;
use App\Models\PlanOffer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CreateOffers
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $company;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try {
            DB::beginTransaction();

            foreach (operators() as $operator) {
                $this->company->offers()->create(
                    [
                    'operator_id' => $operator['id'],
                    ]
                );
            }

            $this->company->offers->each(
                function ($offer) {
                    $operator_id = $offer->operator_id;
                    Plan::whereOperatorId($operator_id)->get()->each(
                        fn($plan) => $offer->plans()->attach(
                            $plan->id,
                            [
                            'price_org' => $plan->price,
                            'price_new' => $plan->price,
                            ]
                        )
                    );
                }
            );

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
