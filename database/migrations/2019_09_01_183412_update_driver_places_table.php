<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDriverPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('driver_places', function (Blueprint $table) {
            $table->float('miles_driven');
            $table->unsignedBigInteger('jobs_booked');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('driver_places', function (Blueprint $table) {
            $table->dropColumn('miles_driven', 'jobs_booked');
        });
    }
}
