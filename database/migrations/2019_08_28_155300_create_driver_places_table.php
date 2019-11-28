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
            $table->string('level')->default('none');
            $table->string('disc')->default('');
            $table->string('vehicle_registration')->default('');
            $table->string('national_insurance_number')->default('')->nullable();
            $table->string('driving_licence_number')->default('');
            $table->unsignedBigInteger('stars')->default(0);
            $table->unsignedBigInteger('votes')->default(0);
            $table->float('miles_driven')->default(5.00);
            $table->unsignedBigInteger('jobs_booked')->default(1);

            $table->string('address')->default('Trafalgar Square, Charing Cross, London WC2N 5DU, UK')->nullable();
            $table->string('city')->default('London')->nullable();
            $table->string('postcode')->default('WC2N 5DU')->nullable();
            $table->float('lat', 10, 6)->default(51.507547)->nullable();
            $table->float('lng', 10, 6)->default(-0.127883)->nullable();
            $table->unsignedSmallInteger('distance')->default(50)->nullable();
            
            
            $table->float('price_small_van_weekday')->nullable();
            $table->float('price_small_van_weekday1')->nullable();
            $table->float('price_small_van_weekday2')->nullable();
            $table->float('price_small_van_weekday3')->nullable();
            $table->float('price_small_van_weekday4')->nullable();
            $table->float('price_small_van_weekend')->nullable();
            $table->float('price_small_van_weekend1')->nullable();
            $table->float('price_small_van_weekend2')->nullable();
            $table->float('price_small_van_weekend3')->nullable();
            $table->float('price_small_van_weekend4')->nullable();

            $table->float('price_mid_van_weekday')->nullable();
            $table->float('price_mid_van_weekday1')->nullable();
            $table->float('price_mid_van_weekday2')->nullable();
            $table->float('price_mid_van_weekday3')->nullable();
            $table->float('price_mid_van_weekday4')->nullable();
            $table->float('price_mid_van_weekend')->nullable();
            $table->float('price_mid_van_weekend1')->nullable();
            $table->float('price_mid_van_weekend2')->nullable();
            $table->float('price_mid_van_weekend3')->nullable();
            $table->float('price_mid_van_weekend4')->nullable();

            $table->float('price_large_van_weekday')->nullable();
            $table->float('price_large_van_weekday1')->nullable();
            $table->float('price_large_van_weekday2')->nullable();
            $table->float('price_large_van_weekday3')->nullable();
            $table->float('price_large_van_weekday4')->nullable();
            $table->float('price_large_van_weekend')->nullable();
            $table->float('price_large_van_weekend1')->nullable();
            $table->float('price_large_van_weekend2')->nullable();
            $table->float('price_large_van_weekend3')->nullable();
            $table->float('price_large_van_weekend4')->nullable();

            $table->float('price_giant_van_weekday')->nullable();
            $table->float('price_giant_van_weekday1')->nullable();
            $table->float('price_giant_van_weekday2')->nullable();
            $table->float('price_giant_van_weekday3')->nullable();
            $table->float('price_giant_van_weekday4')->nullable();
            $table->float('price_giant_van_weekend')->nullable();
            $table->float('price_giant_van_weekend1')->nullable();
            $table->float('price_giant_van_weekend2')->nullable();
            $table->float('price_giant_van_weekend3')->nullable();
            $table->float('price_giant_van_weekend4')->nullable();
            
            $table->float('price_stop')->nullable();
            $table->float('price_mile')->nullable();
            $table->float('price_stairs')->nullable();
           

            
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
