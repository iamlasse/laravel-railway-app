<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'plan_subscription', function (Blueprint $table) {
                $table->id('id');

                $table->foreignId('subscription_id')->constrained('subscriptions')->cascadeOnDelete();
                $table->foreignId('plan_id')->nullable()->constrained('plans');
                $table->foreignId('vaxel_plan_id')->nullable()->constrained('plans');
                $table->integer('operator_id');
                // $table->smallInteger('status')->default(1);
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_subscription');
    }
}
