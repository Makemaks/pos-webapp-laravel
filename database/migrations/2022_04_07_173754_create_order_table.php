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
            $table->bigInteger('order_user_id');
            $table->bigInteger('order_store_id')->nullable();
            $table->bigInteger('ordertable_account_id')->nullable();
            $table->bigInteger('ordertable_id')->nullable();
            $table->string('ordertable_type')->nullable()->comment('user');
            $table->json('order_status')->comment('cancelled::refunded'); 
            $table->json('order_group')->nullable();
            $table->tinyInteger('order_type')->default(0)->comment('internal::external'); 
            $table->float('order_amount_received')->nullable();
            $table->text('order_note')->nullable();
            $table->json('order_delivery')->nullable(); //order details::shipped at
            $table->json('order_discount')->nullable(); //extra discount can be added
            $table->json('order_finalise_key')->nullable();
            $table->bigInteger('order_setting_pos_id');
            $table->json('order_setting_vat')->nullable(); //extra vat can be added

           
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

