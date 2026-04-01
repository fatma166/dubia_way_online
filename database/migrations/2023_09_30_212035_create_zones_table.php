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
        Schema::create('zones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->polygon('coordinates')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->string('restaurant_wise_topic')->nullable();
            $table->string('customer_wise_topic')->nullable();
            $table->string('deliveryman_wise_topic')->nullable();
            $table->double('minimum_shipping_charge', 16, 3)->unsigned()->nullable();
            $table->double('per_km_shipping_charge', 16, 3)->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zones');
    }
};
