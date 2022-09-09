<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'subscriptions', function (Blueprint $table) {
                $table->id();
                $table->json('numbers')->nullable();
                $table->string('name');
                $table->string('department')->nullable();
            
                $table->foreignId('current_plan_id')->constrained('plans')->cascadeOnUpdate();
                $table->bigInteger('current_plan_usage')->default(0);
                $table->bigInteger('current_plan_data')->default(0);
            
                $table->foreignId('company_id')->constrained('companies')->cascadeOnUpdate();
                $table->integer('status');
                $table->boolean('to_be_cancelled')->default(false);
            
                $table->boolean('vaxel_user')->default(false);
                $table->string('type')->default('M');
            
                $table->timestamps();
                $table->softDeletes();

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
        Schema::dropIfExists('subscriptions');
    }
}
