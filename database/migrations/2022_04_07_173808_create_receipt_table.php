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

            $table->tinyInteger('receipt_stock_cost_id')->comment('stock_merchandise');
            $table->float('receipt_stock_cost_override')->nullable();

            $table->smallInteger('receipt_quantity')->default(1); 
            $table->tinyInteger('receipt_status')->comment('processed::cancelled::refunded')->default(0);
            $table->bigInteger('receipt_order_id');
            $table->bigInteger('receipt_user_id')->comment('user');
            $table->bigInteger('receipt_stock_offer_id')->nullable(); //customer
            
            
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
