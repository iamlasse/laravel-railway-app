<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'offers', function (Blueprint $table) {
                $table->id('id');
                $table->foreignId('operator_id');
                $table->boolean('is_current_vaxel')->nullable();
                $table->boolean('is_current_operator')->nullable();
                $table->boolean('is_recommended')->nullable();
                $table->foreignId('company_id')->constrained('companies')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('offers');
    }
}
