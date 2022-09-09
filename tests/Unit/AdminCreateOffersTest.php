<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Offer;
use App\Models\Plan;
use App\Models\PlanOffer;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class AdminCreateOffersTest extends TestCase
{
    use LazilyRefreshDatabase;
    protected $seed = true;
    /**
     * A basic unit test example.
     *
     * @return void
     * @test
     */
    public function itCanCreateOffersWithPlans()
    {
        $company = Company::factory()->createQuietly();
        $jobCreateOffers = new \App\Jobs\CreateOffers($company);
        $jobCreateOffers->handle();
        $this->assertCount(5, $company->offers);
    // $this->assertCount(17, PlanOffer::whereIn('offer_id', $company->offers()->pluck('id'))->get());
    }
}
