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
        Schema::create('event', function (Blueprint $table) {
            $table->bigIncrements('event_id');
            $table->bigInteger('event_account_id');
            $table->bigInteger('event_user_id');
            $table->string('event_name');
            $table->text('event_description')->nullable();
            $table->json('event_note')->nullable()->comment('user_id::description::created_at'); //
            $table->json('event_ticket')->nullable()->commenmt('name::type::quantity::cost::row');
            $table->json('event_file')->nullable()->comment('user_id::name::location::type');
            $table->json('event_floorplan')->nullable()->comment('setting_building_id::setting_room_id'); 
            
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
        Schema::dropIfExists('event');
    }
};
