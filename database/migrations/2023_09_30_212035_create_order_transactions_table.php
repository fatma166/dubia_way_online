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
        Schema::create('order_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('delivery_man_id')->nullable();
            $table->unsignedBigInteger('order_id');
            $table->decimal('order_amount', 24);
            $table->decimal('restaurant_amount', 24);
            $table->decimal('admin_commission', 24);
            $table->string('received_by');
            $table->decimal('original_delivery_charge', 24)->default(0);
            $table->decimal('tax', 24)->default(0);
            $table->string('status')->nullable();
            $table->timestamps();
            $table->decimal('delivery_charge', 24)->default(0);
            $table->unsignedBigInteger('zone_id')->nullable()->index();
            $table->double('dm_tips', 24, 2)->default(0);
            $table->double('delivery_fee_comission', 24, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_transactions');
    }
};
