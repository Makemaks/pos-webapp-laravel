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
        Schema::create('expense', function (Blueprint $table) {
            $table->bigIncrements('expense_id');
            $table->bigInteger('expense_user_id');
            $table->bigInteger('expense_store_id')->comment('added_by'); 
            $table->text('expense_description');
            $table->float('expense_amount');
            $table->tinyInteger('expense_frequency')->nullable();
            $table->tinyInteger('expense_frequency_period_id')->nullable()->comment('Day::Week,Month::Year');
            $table->tinyInteger('expense_setting_expense_type')->nullable();
            $table->text('expense_image')->nullable();
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
        Schema::dropIfExists('expense');
    }
};
