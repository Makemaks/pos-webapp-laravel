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
            $table->json('address_line');
            $table->string('address_town');
            $table->string('address_county')->nullable();
            $table->string('address_postcode');
            $table->string('address_country');
            $table->json('address_geolocation')->nullable();
            $table->json('address_email')->nullable();
            $table->json('address_phone')->nullable();
            $table->json('address_website')->nullable();
            $table->tinyInteger('address_building_type')->nullable()->comment('home::hork');
            $table->tinyInteger('address_delivery_type')->nullable()->comment('billing::shipping');
            $table->bigInteger('addresstable_id')->comment('person::company::store');
            $table->string('addresstable_type'); //person/company
            $table->tinyInteger('address_default');
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
