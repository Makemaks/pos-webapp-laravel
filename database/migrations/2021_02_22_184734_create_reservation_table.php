<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatereservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation', function (Blueprint $table) {
            $table->bigIncrements('reservation_id');
            $table->mediumText('reservation_description');
            $table->json('reservation_guest')->nullable();
            $table->bigInteger('reservation_user_id');
            $table->bigInteger('reservation_account_id');
            $table->DateTime('reservation_timestamp')->nullable();
            $table->bigInteger('reservation_quantity');
            $table->bigInteger('reservation_payment_id')->nullable();
            $table->mediumText('reservation_note')->nullable();
            $table->float('reservation_no_show_fee')->nulable();
            $table->float('reservation_deposit')->nullable();
            $table->json('reservation_datetime')->comment('start_date', 'end_date');
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
        Schema::dropIfExists('reservation');
    }
}
