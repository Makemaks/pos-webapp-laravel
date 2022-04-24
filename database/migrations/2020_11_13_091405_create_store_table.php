<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store', function (Blueprint $table) {
            $table->bigIncrements('store_id');
            $table->string('store_name');
            $table->text('store_location')->nullable();
            $table->bigInteger('root_store_id')->nullable();
            $table->bigInteger('store_account_id');
            $table->bigInteger('store_company_id');
            $table->json('store_business_hours')->nullable();
            $table->string('store_image')->nullable();
            
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
        Schema::dropIfExists('store');
    }
}
