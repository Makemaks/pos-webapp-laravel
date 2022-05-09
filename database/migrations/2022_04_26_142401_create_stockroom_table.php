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
        Schema::create('stockroom', function (Blueprint $table) {
            $table->bigIncrements("stockroom_id");
            $table->text('stockroom_note')->nullable();
            $table->string('stockroom_reference')->nullable();
            $table->bigInteger('stockroom_store_id');
            $table->bigInteger('stockroom_stock_id');
            $table->bigInteger('stockroom_user_id');
            $table->float('stockroom_price')->nullable();
            $table->bigInteger('stockroom_quantity');
            $table->smallInteger('stockroom_status');
            $table->smallInteger('stockroom_type');
            
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
        Schema::dropIfExists('stockroom');
    }
};
