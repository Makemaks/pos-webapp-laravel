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
        Schema::create('employement', function (Blueprint $table) {
            $table->bigIncrements('employement_id');
            $table->bigInteger('employement_user_id');
            $table->json('employement_general');
            $table->json('employement_level_default');
            $table->json('employement_commision');
            $table->json('employement_allowed_function');
            $table->json('employement_allowed_mode');
            $table->json('employement_employee_job');
            $table->json('employement_user_control');
            $table->json('employement_user_pay');
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
        Schema::dropIfExists('employement');
    }
};
