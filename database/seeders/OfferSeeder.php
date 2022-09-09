<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = Company::all();

        $companies->each(
            function (Company $company) {
                $offers = Offer::factory(5)->state(
                    new Sequence(
                        [
                        'operator_id' => 1,
                        'is_current_operator' => true,
                        'is_recommended' => true
                        ],
                        [
                        'operator_id' => 2,
                        ],
                        [
                        'operator_id' => 3,
                        'is_current_vaxel' => true
                        ],
                        [
                        'operator_id' => 4,
                        ],
                        [
                        'operator_id' => 5,
                        ]
                    )
                )->make(
                    [
                    'company_id' => $company->id,
                
                    ]
                );
            
                $company->offers()->saveMany($offers);
            }
        );
    }
}
