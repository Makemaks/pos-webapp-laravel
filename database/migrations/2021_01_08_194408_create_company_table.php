<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->bigIncrements('company_id');
            $table->string('company_name');
            $table->tinyInteger('company_type')->comment('supplier = 0::customer = 1 :: contractor = 2');
            $table->bigInteger('company_store_id')->comment('added_by'); 
            $table->bigInteger('parent_company_id')->nullable();
            $table->json('company_contact')->nullable();
            $table->json('company_hour')->nullable()->comment('opening hours');
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
        Schema::dropIfExists('company');
    }
}
