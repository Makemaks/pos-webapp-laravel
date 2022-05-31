<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->bigIncrements('account_id');
            $table->bigInteger('account_system_id');
            $table->bigInteger('accountable_id');
            $table->string('accountable_type');
            $table->string('account_name')->nullable();
            $table->tinyInteger('account_type')->comment('SAAS::B2B::B2B');
            $table->string('account_description');
            $table->bigInteger('parent_account_id')->nullable();
            $table->json('account_blacklist')->nullable();
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
        Schema::dropIfExists('account');
    }
}
