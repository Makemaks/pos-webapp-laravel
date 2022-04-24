<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->bigIncrements('address_id');
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('address_line_3')->nullable();
            $table->string('address_town');
            $table->string('address_county')->nullable();
            $table->string('address_postcode');
            $table->string('address_country');
            $table->string('address_longitude')->nullable();
            $table->string('address_latitude')->nullable();
            $table->string('address_email_1')->nullable();
            $table->string('address_email_2')->nullable();
            $table->string('address_phone_1')->nullable();
            $table->string('address_phone_2')->nullable();
            $table->string('address_website_1')->nullable();
            $table->string('address_website_2')->nullable();
            $table->tinyInteger('address_type')->nullable()->comment('Yes::No');
            $table->tinyInteger('address_delivery_type')->nullable()->comment('billing::shipping');
            $table->bigInteger('addresstable_id');
            $table->string('addresstable_type'); //person/company
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
        Schema::dropIfExists('address');
    }
}
