<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistConcertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artist_concert', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("artist_id");
            $table->foreign("artist_id")->references("id")->on("artists");
            $table->unsignedBigInteger("concert_id");
            $table->foreign("concert_id")->references("id")->on("concerts");
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
        Schema::dropIfExists('artist_concert');
    }
}
