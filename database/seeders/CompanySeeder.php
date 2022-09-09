<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Company;
use App\Models\CompanyUser;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Company::factory(3)->hasAddress(1)->createQuietly()->each(function ($company) {
        //     // CompanyUser::factory(random_int(1, 3))->withRole()->create([
        //     //     'company_id' => $company->id
        //     // ]);
        // });

        Company::factory()->hasAddress(1)->create(
            [
            'name' => 'Winterfell AB',
            'current_monthly_cost' => 17_056,
            'over_paying' => 248_000
            ]
        );
    }
}
