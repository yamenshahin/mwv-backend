<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDriverPlacesTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('driver_places', function (Blueprint $table) {
            $table->float('price_small_van_weekday1');
            $table->float('price_small_van_weekday2');
            $table->float('price_small_van_weekday3');
            $table->float('price_small_van_weekday4');
            $table->float('price_small_van_weekend1');
            $table->float('price_small_van_weekend2');
            $table->float('price_small_van_weekend3');
            $table->float('price_small_van_weekend4');

            $table->float('price_mid_van_weekday1');
            $table->float('price_mid_van_weekday2');
            $table->float('price_mid_van_weekday3');
            $table->float('price_mid_van_weekday4');
            $table->float('price_mid_van_weekend1');
            $table->float('price_mid_van_weekend2');
            $table->float('price_mid_van_weekend3');
            $table->float('price_mid_van_weekend4');

            $table->float('price_large_van_weekday1');
            $table->float('price_large_van_weekday2');
            $table->float('price_large_van_weekday3');
            $table->float('price_large_van_weekday4');
            $table->float('price_large_van_weekend1');
            $table->float('price_large_van_weekend2');
            $table->float('price_large_van_weekend3');
            $table->float('price_large_van_weekend4');

            $table->float('price_giant_van_weekday1');
            $table->float('price_giant_van_weekday2');
            $table->float('price_giant_van_weekday3');
            $table->float('price_giant_van_weekday4');
            $table->float('price_giant_van_weekend1');
            $table->float('price_giant_van_weekend2');
            $table->float('price_giant_van_weekend3');
            $table->float('price_giant_van_weekend4');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
