<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDynamicPageMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamic_page_metas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dynamic_page_id');
            $table->string('key');
            $table->longText('value')->nullable();
            
            $table->foreign('dynamic_page_id')->references('id')->on('dynamic_pages');
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
        Schema::dropIfExists('dynamic_page_metas');
    }
}
