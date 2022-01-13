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
        Schema::create('rate_movies', function (Blueprint $table) {
            $table->id();
            $table->string('Movie_title', 32)->nullable();
            $table->string('Username', 32)->nullable();
            $table->integer('Rating')->nullable();
            $table->text('R_description')->nullable();
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
        Schema::dropIfExists('rate_movies');
    }
};
