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

            $table->string('stock_name');
            $table->text('stock_description');
            $table->mediumText('stock_random_code')->nullable();
            $table->json('stock_group_category_plu')->nullable();
            $table->text('stock_barcode');
           
            
            $table->json('stock_cost')->nullable(); // as array
            $table->smallInteger('stock_quantity')->nullable(); // as array
            $table->json('stock_supplier')->nullable(); // as array
            $table->float('stock_rrp')->nullable(); // as array
         
            
            $table->smallInteger('stock_alert_level')->nullable();

            $table->json('stock_merchandise')->nullable();

            $table->text('stock_image')->nullable();
            $table->bigInteger('stock_store_id')->comment('added_by'); 
            $table->tinyInteger('stock_vat_id')->nullable();
            $table->date('stock_expiration_date')->nullable();

            $table->json('stock_offers')->nullable();

            $table->json('stock_boolean')->nullable();
            $table->json('stock_tag')->nullable();
            $table->json('stock_gross_profit')->nullable();
            $table->json('stock_recipe')->nullable();
            $table->json('stock_allergen')->nullable();
            $table->json('stock_nutrition')->nullable();
            $table->json('stock_print_exclusion')->nullable();
            $table->text('stock_web')->nullable();

            $table->json('stock_transfer')->nullable();

            $table->json('stock_termminal_flags')->nullable();

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
