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
<<<<<<< HEAD
            
            $table->json('setting_logo')->nullable();
           
           
            $table->json('setting_stock_group_category_plu')->nullable();

            $table->json('setting_stock_allergen')->nullable();
            $table->json('setting_stock_nutrition')->nullable();
           
            $table->json('setting_stock_label')->nullable();
            $table->json('setting_stock_voucher')->nullable();
            
            $table->json('setting_printer')->nullable();
            $table->json('setting_stock_tag_group')->nullable();
            
            
            $table->json('setting_message_notification_category')->nullable();
            $table->json('setting_message_group')->nullable();

            $table->json('setting_reason')->nullable();
            $table->json('setting_vat')->nullable();

            $table->json('setting_expense_budget')->nullable();
            $table->json('setting_expense_type')->nullable();
            
            $table->json('setting_pos')->nullable()->comment('Tills');

            $table->json('setting_keys')->nullable();

            $table->json('setting_receipt')->nullable();
            $table->json('setting_mix_match')->nullable();
            $table->json('setting_payment_gateway')->nullable();
            
           
=======
            $table->string('setting_logo_url')->nullable();
           
            $table->json('setting_stock_type')->nullable();
            $table->json('setting_stock_category')->nullable();
            $table->json('setting_stock_group')->nullable();
            $table->json('setting_stock_plu')->nullable();
            $table->json('setting_stock_allergen')->nullable();
            $table->json('setting_stock_nutrition')->nullable();
            $table->json('setting_stock_rate')->nullable();
            
            $table->json('setting_printer')->nullable();
            
            $table->json('setting_message_group')->nullable();
            
            $table->json('setting_message_notification_category')->nullable();
            $table->json('setting_payment_gateway')->nullable();
            $table->json('setting_country')->nullable();
            $table->json('setting_expense_type')->nullable();
            $table->json('setting_expense_budget')->nullable();
            $table->json('setting_store_vat')->nullable();
            $table->json('setting_pos')->nullable()->comment('Tills');
>>>>>>> 8a9d0a79023167e539fee6603713f1b695fb30b7
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

