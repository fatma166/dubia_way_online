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
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 100)->nullable();
            $table->string('code', 15)->nullable()->unique();
            $table->date('start_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->decimal('min_purchase', 24)->default(0);
            $table->decimal('max_discount', 24)->default(0);
            $table->decimal('discount', 24)->default(0);
            $table->string('discount_type', 15)->default('percentage');
            $table->string('coupon_type')->default('default');
            $table->integer('limit')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('restaurant_id');
            $table->timestamps();
            $table->string('data')->nullable();
            $table->bigInteger('total_uses')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};
