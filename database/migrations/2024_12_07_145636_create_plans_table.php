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
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('currency', 12);
            $table->tinyInteger('decimals')->nullable();
            $table->double('amount_month', 8, 2)->nullable();
            $table->double('amount_year', 8, 2)->nullable();
            $table->text('coupons')->nullable();
            $table->text('tax_rates')->nullable();
            $table->tinyInteger('visibility')->nullable();
            $table->text('features')->nullable();
            $table->string('color', 32)->nullable();
            $table->tinyInteger('status')->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
