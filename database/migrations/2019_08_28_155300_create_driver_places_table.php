<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_places', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('address');
            $table->float('lat', 10, 6);
            $table->float('lng', 10, 6);
            $table->unsignedSmallInteger('distance');
            $table->unsignedBigInteger('stars');
            $table->unsignedBigInteger('votes');
            $table->float('price_small_van_weekday');
            $table->float('price_small_van_weekend');
            $table->float('price_mid_van_weekday');
            $table->float('price_mid_van_weekend');
            $table->float('price_large_van_weekday');
            $table->float('price_large_van_weekend');
            $table->float('price_giant_van_weekday');
            $table->float('price_giant_van_weekend');
            $table->float('price_stop');
            $table->float('price_mile');
            $table->float('price_step');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_places');
    }
}
