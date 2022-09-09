<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'companies', function (Blueprint $table) {
                // $table->renameColumn('currently_paying', 'current_monthly_cost');
                $table->integer('current_monthly_flex_cost')->default(0)->after('current_monthly_cost');

                $table->datetime('period_starts_at')->nullable();
                $table->dateTime('period_ends_at')->nullable();

                $table->datetime('offer_ends_at')->nullable();
                $table->datetime('offer_expired_at')->nullable();
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
        Schema::table(
            'companies', function (Blueprint $table) {
                $table->renameColumn('current_monthly_cost', 'currently_paying');
            }
        );
    }
};
