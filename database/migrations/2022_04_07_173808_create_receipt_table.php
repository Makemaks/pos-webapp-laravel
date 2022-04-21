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
        Schema::create('receipt', function (Blueprint $table) {
            $table->bigIncrements('receipt_id');
            $table->bigInteger('receipt_stock_transfer_id')->nullable(); //has id if transffered
            
            $table->bigInteger('receipttable_id');
            $table->string('receipttable_type');

            $table->tinyInteger('receipt_stock_cost_id'); //taken from product cost
            

            $table->smallInteger('receipttable_quantity')->default(1); 
            $table->tinyInteger('receipttable_status')->default(0); //processed//cancelled/refunded
            $table->bigInteger('receipt_order_id')->nullable();
            $table->bigInteger('receipt_user_id'); //customer
            $table->bigInteger('receipt_stock_plan_id')->nullable(); //customer
            
            
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
        Schema::dropIfExists('receipts');
    }
};
