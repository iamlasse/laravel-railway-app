<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'addresses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('company_id')->references('id')->on('companies')->onDelete('cascade');
                $table->string('gatunamn')->nullable();
                $table->string('postnr')->nullable();
                $table->string('postort')->nullable();
                $table->timestamps();
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
        Schema::dropIfExists('addresses');
    }
}
