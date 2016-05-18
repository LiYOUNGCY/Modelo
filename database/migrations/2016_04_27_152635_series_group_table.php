<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeriesGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('series_id')->unsigned();
            $table->bigInteger('image_id')->unsigned();

            $table->timestamps();

            $table->foreign('image_id')
                ->references('id')
                ->on('image')
                ->onDelete('cascade');

            $table->foreign('series_id')
                ->references('id')
                ->on('series')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('series_group');
    }
}
