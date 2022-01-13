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
        Schema::create('movies', function (Blueprint $table) {
            $table->id('Movie_ID');
            $table->string('Title', 32)->nullable();
            $table->date('Publish')->nullable();
            $table->integer('Length')->nullable();
            $table->text('Description')->nullable();
            $table->string('Mpaa_rating', 10)->nullable();
            $table->text('Genre')->nullable();
            $table->string('Director', 32)->nullable();
            $table->text('Performer')->nullable();
            $table->string('Language', 10)->nullable();
            $table->string('Theater_name', 32)->nullable();
            $table->dateTime('Start_time')->nullable();
            $table->dateTime('End_time')->nullable();
            $table->integer('Theater_room_no')->nullable();
            $table->float('Overall_rating')->nullable();
            $table->date('R_date')->nullable();
            $table->date('D_date')->nullable();
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
        Schema::dropIfExists('movies');
    }
};
