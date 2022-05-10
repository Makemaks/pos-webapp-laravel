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
            $table->bigInteger('order_user_id'); //employee
            $table->tinyInteger('order_status'); //cancelled/refunded
            $table->text('order_plan')->nullable();
            $table->tinyInteger('order_type')->default(0)->comment('Internal::External'); 
            $table->float('order_amount_received')->nullable();
            $table->dateTime('order_shipped_at')->nullable();
            $table->bigInteger('order_store_id')->comment('added_by'); 
            $table->json('order_scheme')->nullable();
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
