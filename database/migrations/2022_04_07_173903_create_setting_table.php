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
        Schema::create('setting', function (Blueprint $table) {
            $table->bigIncrements('setting_id');
            $table->bigInteger('setting_store_id')->comment('added_by'); 
            
            $table->json('setting_logo')->nullable();
           
           
            $table->json('setting_stock_group_category_plu')->nullable()->comment('category::group::plu::brand');

            $table->json('setting_stock_label')->nullable();
            
            $table->json('setting_stock_recipe')->nullable();
            $table->json('setting_stock_case_size')->nullable(); 
            
            $table->json('setting_printer')->nullable();
            $table->json('setting_stock_tag_group')->nullable();
            $table->json('setting_stock_tag')->nullable();
            
            $table->json('setting_message_notification_category')->nullable();
            $table->json('setting_message_group')->nullable();

            $table->json('setting_reason')->nullable();
            $table->json('setting_vat')->nullable();

            $table->json('setting_expense_budget')->nullable();
            $table->json('setting_expense_type')->nullable();
            
            $table->json('setting_pos')->nullable()->comment('Tills');

            $table->json('setting_keys')->nullable();

            $table->json('setting_receipt')->nullable();
            
            $table->json('setting_payment_gateway')->nullable();
            
            $table->json('setting_stock_allergen')->nullable();
            $table->json('setting_stock_nutrition')->nullable();
            $table->json('setting_stock_offer')->nullable();

            $table->json('setting_stock_set_menu')->nullable();
           
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
        Schema::dropIfExists('setting');
    }
};

