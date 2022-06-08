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
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->bigInteger('user_account_id');
            $table->bigInteger('user_person_id');
            $table->string('email')->unique();
            $table->tinyInteger('user_type')->comment('admin::super::user');
            $table->tinyInteger('user_is_disabled')->default(0);
            $table->tinyInteger('user_is_notifiable')->default(1);
            $table->tinyInteger('user_is_verified')->default(1)->comment('given accesss');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('user_avatar')->nullable();
            $table->string('password');
            $table->dateTime('user_last_login_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('user');
    }
};
