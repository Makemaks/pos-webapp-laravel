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
            $table->bigInteger('receipt_warehouse_id')->nullable(); //has id if transffered
            
            $table->bigInteger('receipttable_id');
            $table->string('receipttable_type');

            $table->smallInteger('receipt_vat_id')->nullable(); 
            $table->bigInteger('receipt_stock_id')->comment('stock_cost');
            $table->json('receipt_stock_cost_override')->nullable()->comment('OverrideType::Amount');

            $table->smallInteger('receipt_quantity')->default(1); 
            $table->tinyInteger('receipt_status')->comment('processed::cancelled::refunded')->default(0);
            $table->bigInteger('receipt_order_id');
            $table->bigInteger('receipt_user_id')->comment('added_by');
            $table->bigInteger('receipt_stock_offer')->nullable(); //customer
            
            $table->json('receipt_stock_cost')->nullable();
            $table->text('receipt_note')->nullable();

            $table->tinyInteger('receipt_setting_pos_id');

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
        Schema::dropIfExists('receipt');
    }
};
