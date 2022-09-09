<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(
            [
            PermissionSeeder::class,
            PlanSeeder::class,
            UsersSeeder::class,
            CompanySeeder::class,
            OfferSeeder::class,
            OfferPlanSeeder::class,
            // SubscriptionSeeder::class,
            // PlanSubscriptionSeeder::class,
            // TagSeeder::class,
            // ReplySeeder::class,
            // NotificationSeeder::class,
            // LikeSeeder::class,
            ]
        );
    }
}
