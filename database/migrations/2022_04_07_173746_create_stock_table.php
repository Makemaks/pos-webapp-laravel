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
        Schema::create('stock', function (Blueprint $table) {
            $table->bigIncrements('stock_id');
            $table->bigInteger('stock_parent_id')->nullable(); //always selected variation

            
            $table->json('stock_cost')->nullable(); // as array
            
            $table->json('stock_supplier')->nullable(); // as array
            

            $table->json('stock_merchandise')->nullable();

           

            $table->bigInteger('stock_store_id')->comment('added_by'); 
            
            
            $table->json('stock_gross_profit')->nullable();
            
            $table->json('stock_allergen')->nullable();
            $table->json('stock_nutrition')->nullable();
            
            $table->json('stock_web')->nullable();

            $table->json('stock_terminal_flag')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('stock');
    }
};
