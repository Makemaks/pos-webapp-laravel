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
        Schema::create('employment', function (Blueprint $table) {
            $table->bigIncrements('employment_id');
            $table->bigInteger('employment_user_id');
            $table->json('employment_general');
            $table->json('employment_level_default');
            $table->json('employment_commision');
            $table->json('employment_setup');
            $table->json('employment_user_pay');
            $table->tinyInteger('employment_working_hour')->nullable();
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
        Schema::dropIfExists('employment');
    }
};
