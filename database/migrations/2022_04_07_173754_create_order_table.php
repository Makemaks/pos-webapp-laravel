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
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('order_id');
            $table->bigInteger('ordertable_id')->nullable()->comment('customer');
            $table->string('ordertable_type')->nullable()->comment('company::user');
            $table->tinyInteger('order_status')->comment('cancelled::refunded'); 
            $table->json('order_offer')->nullable();
            $table->tinyInteger('order_type')->default(0)->comment('internal::external'); 
            $table->float('order_amount_received')->nullable();
            $table->dateTime('order_shipped_at')->nullable();
            $table->text('order_note')->nullable();
            $table->json('order_delivery')->nullable();
            $table->json('order_discount')->nullable();
            $table->json('order_finalise_key')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
};

