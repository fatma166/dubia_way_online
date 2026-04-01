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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone', 20)->unique();
            $table->string('email', 100)->nullable();
            $table->string('logo')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('address')->nullable();
            $table->text('footer_text')->nullable();
            $table->decimal('minimum_order', 24)->default(0);
            $table->decimal('comission', 24)->nullable();
            $table->time('opening_time')->nullable()->default('10:00:00');
            $table->time('closeing_time')->nullable()->default('23:00:00');
            $table->boolean('free_delivery')->default(false);
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('vendor_id');
            $table->timestamps();
            $table->string('rating')->nullable();
            $table->string('cover_photo')->nullable();
            $table->boolean('delivery')->default(true);
            $table->boolean('take_away')->default(true);
            $table->boolean('schedule_order')->default(false);
            $table->boolean('food_section')->default(true);
            $table->decimal('tax', 24)->default(0);
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->boolean('reviews_section')->default(true);
            $table->boolean('active')->default(true);
            $table->string('off_day')->default(' ');
            $table->string('gst')->nullable();
            $table->boolean('self_delivery_system')->default(false);
            $table->boolean('pos_system')->default(false);
            $table->decimal('delivery_charge', 24)->default(0);
            $table->string('delivery_time', 10)->nullable()->default('30-40');
            $table->boolean('veg')->default(true);
            $table->boolean('non_veg')->default(true);
            $table->integer('order_count')->default(0);
            $table->float('minimum_shipping_charge', 10, 0)->default(0);
            $table->float('per_km_shipping_charge', 10, 0)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
};
