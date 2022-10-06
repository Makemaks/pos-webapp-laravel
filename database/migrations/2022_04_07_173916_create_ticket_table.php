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
        Schema::create('ticket', function (Blueprint $table) {
            $table->bigIncrements('ticket_id');
            $table->bigInteger('ticket_account_id');
            $table->bigInteger('ticket_user_id');
            $table->string('ticket_name');
            $table->text('ticket_description')->nullable();
            $table->json('ticket_note')->nullable()->comment('user_id::description::created_at'); //
            $table->json('ticket_group')->nullable()->commenmt('name::type::quantity');
            $table->json('ticket_file')->nullable()->comment('user_id::name::location::type');
            $table->json('ticket_floorplan')->nullable()->comment('setting_building_id::setting_room_id'); 
            
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
        Schema::dropIfExists('ticket');
    }
};
