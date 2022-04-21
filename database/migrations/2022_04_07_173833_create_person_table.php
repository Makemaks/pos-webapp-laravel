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
        Schema::create('person', function (Blueprint $table) {
            $table->bigIncrements('person_id');
            $table->bigInteger('person_user_id');  //user that added this account
            $table->bigInteger('persontable_id');
            $table->string('persontable_type')->comment('Store::Company'); //store that added this account

            $table->json('person_name')->comment('person_firstname::person_lastname::person_preferred_name');
            $table->datetime('person_dob')->nullable();

            $table->tinyInteger('person_type')->nullable()->comment('Staff');
            $table->tinyInteger('person_custodian_type')->nullable();
            //$table->json('person_group')->nullable()->comment('person_id, person_group_type => Guardian::Child::Custodian');

            $table->json('person_contact_user_id')->nullable()->comment('user_id');
            $table->string('person_role')->nullable();
            $table->json('person_email')->nullable();
            $table->json('person_phone')->nullable();
            
            $table->json('person_message_notification')->nullable()->comment('user_id, person_message_group => message_group');
           
            $table->text('person_status')->nullable();
            $table->text('person_background_image')->nullable();

            $table->json('person_message_group')->nullable()->comment('create message group');
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
        Schema::dropIfExists('person');
    }
};
