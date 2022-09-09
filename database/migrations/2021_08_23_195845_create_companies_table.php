<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'companies', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('reg_nr')->unique();
            
                $table->foreignId('contact_id')->nullable()->references('id')->on('users')->onDelete('set null');
                $table->string('phone')->nullable();
                $table->foreignId('rep_id')->nullable()->references('id')->on('users')->cascadeOnUpdate();
                $table->integer('current_monthly_cost')->default(0);
                $table->integer('over_paying')->default(0);
                $table->integer('selected_operator')->nullable();
                $table->boolean('order_in_progress')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
