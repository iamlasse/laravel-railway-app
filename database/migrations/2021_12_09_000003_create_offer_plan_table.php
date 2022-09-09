<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'offer_plan', function (Blueprint $table) {
                $table->id();
                $table->foreignId('offer_id')->constrained('offers')->cascadeOnDelete();
                $table->foreignId('plan_id')->constrained('plans');
                $table->bigInteger('price_org')->nullable();
                $table->bigInteger('price_new')->nullable();
                // $table->integer('subscriptions')->nullable()->default(0);
            
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
        Schema::dropIfExists('offer_plan');
    }
}
