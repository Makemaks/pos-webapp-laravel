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
        Schema::create('warehouse', function (Blueprint $table) {
            $table->bigIncrements("warehouse_id");
           
            $table->string('warehouse_name')->nullable();
            $table->bigInteger('warehouse_stock_id');
            $table->json('warehouse_stock_price')->nullable(); // as array
            $table->json('warehouse_stock_price_quantity')->nullable(); // as array
            $table->bigInteger('warehouse_stock_quantity')->nullable(); // as arra
            $table->bigInteger('warehousetable_id')->nullable();
            $table->string('warehousetable_type')->nullable();
            $table->smallInteger('warehouse_status');
            $table->smallInteger('warehouse_type');
            $table->bigInteger('warehouse_store_id');
            $table->bigInteger('warehouse_address_id')->nullable();
            $table->bigInteger('warehouse_user_id');
            $table->bigInteger('warehouse_company_id')->nullable();
            $table->text('warehouse_note')->nullable();
            $table->json('warehouse_reason')->nullable();
           
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
        Schema::dropIfExists('warehouse');
    }
};
